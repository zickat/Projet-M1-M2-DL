<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Enfant;
use App\Classe;
use Illuminate\Http\Request;
use App\Http\Requests\EnfantsRequest;
use App\Reguliere;
use App\Exceptionnelle;
use App\Arret;
use Carbon\Carbon;
use Input;
use App\Library\Feries;

class AffichageController extends Controller {

	
	public function __construct()
	{
		$this->middleware('adsem');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{

	}

	public function cantine()
	{
		$tab = Feries::chargement(); // MODIF 1
		if(date('n') <= 6){
			$annee = date('Y', strtotime('-1 year', strtotime(date('Y'))));
		}else{
			$annee = date('Y');
		}
		$rentree = Feries::jour_rentree($annee,$tab);
		$jour_debut = date('N', strtotime($rentree));
		$diff = -($jour_debut)+1;
		$jourListe = date('Y-m-d',strtotime($diff.'days',strtotime($rentree)));
		$semaines= [];
		$tmp = date('Y-m-d',strtotime('+14days',strtotime(date('Y-m-d') )));
		while ( $jourListe < $tmp ){
			$day = date('N',strtotime($jourListe));
			$diff = 5-$day;
			$debutSemaine = $jourListe;
			$finSemaine = date('Y-m-d',strtotime('+'.$diff.'days',strtotime($debutSemaine)));
			$semaines[] =[ 'debut' =>$debutSemaine , 'fin' => $finSemaine ];
			$jourListe = date('Y-m-d',strtotime('+3 days',strtotime($finSemaine)));
		}
		$jourSelect = Input::get('semaine');
		if($jourSelect == null){
			$dernier_element = end($semaines);
			$dernier_element = prev($semaines);
			$jourSelect = date("Y-m-d",strtotime($dernier_element['debut']));
		}
		$jour = Carbon::now();
		$debutSemaine = $jourSelect;
		$finSemaine = new Carbon($debutSemaine);
		$day = date('N',strtotime($finSemaine));
		$diff = 5-$day;
		$finSemaine->addDay($diff);


		$regs = Reguliere::with(['Enfant', 'Enfant.Classe'])
			->where('type', 'cantine')
			->get();
		$exeps = Exceptionnelle::with(['Enfant', 'Enfant.Classe'])
			->whereBetween('jour', [$debutSemaine, $finSemaine])
			->where('type', 'cantine')
			->get();

		$ferie = [];
		
		for ($i=0; $i < 5 ; $i++) { 
			$monjour = date('Y-m-d', strtotime($i.'day'.$debutSemaine));
			if(Feries::est_ferie($monjour) || Feries::est_vacances($monjour,$tab)){ // MODIF 2
				$ferie[] = $i+1;
			}
		}
		foreach($regs as $reg){
			$inscrits[$reg->enfant_id]['inscription'] = str_split($reg->jours);
			$inscrits[$reg->enfant_id]['enfant'] = $reg;
			if(!empty($ferie)){
				foreach ($ferie as $f) {
					$cle = array_search($f, $inscrits[$reg->enfant_id]['inscription']);
					if($cle !== null){
						unset($inscrits[$reg->enfant_id]['inscription'][$cle]);
					}
				}
			}
		}
		foreach($exeps as $exep){
			if($exep->inscrit === 1){
				$inscrits[$exep->enfant_id]['inscription'][] = date( 'w' , strtotime($exep->jour));
				if(!isset($inscrits[$exep->enfant_id]['enfant'])){
					$inscrits[$exep->enfant_id]['enfant'] = $exep;
				}
			}else{
				$cle = array_search(date('w',strtotime($exep->jour)), $inscrits[$exep->enfant_id]['inscription']);
				if($cle !== false){
					unset($inscrits[$exep->enfant_id]['inscription'][$cle]);
				}
			}
		}
		if(!empty($inscrits)){
			return view('affichage.cantine',compact('inscrits','semaines','jourSelect'));
		}
		else{
			$message="Pas d'inscription en cours.";
			return view('affichage.cantine',compact('message','semaines','jourSelect'));
		}
	}

	public function journalier($type)
	{

		$jour = Input::get('jour');
		if($jour == null){
			$jour = date("Y-m-d");
		}
		$inscrits = [];
		if ( $type == 'garderie'){
			$inscrits = Enfant::where('garderie',true)->get();
		}
		else{
			$regs = Reguliere::with('enfant', 'enfant.classe','enfant.arret')
				->where('jours', 'LIKE', '%'.date('w', strtotime($jour)).'%')
				->where('type', $type)
				->get();
				
			$exeps = Exceptionnelle::with('enfant', 'enfant.classe','enfant.arret')
				->where('jour', date('Y-m-d', strtotime($jour)))
				->where('type', $type)
				->get();
				
			foreach($regs as $reg){
				$inscrits[$reg->enfant_id] = $reg;
			}
			foreach ($exeps as $exep) {
				if($exep->inscrit === 1){
					$inscrits[$exep->enfant_id] = $exep;
				}else{
					unset($inscrits[$exep->enfant_id]);
				}
			}
		}
		$tab = Feries::chargement();
		if (!empty($inscrits)){
				if ( Feries::est_vacances(date('Y-m-d',strtotime($jour)),$tab) ){
					$message = "Pas d'inscription pendant les vacances.";
					return view('affichage.autres',compact('inscrits','message','jour','type'));
				}
				$arrets = Arret::get();
				return view('affichage.autres',compact('inscrits','jour','type','arrets'));
		}
		else{
			$message="Pas d'inscription en cours.";
			return view('affichage.autres',compact('inscrits','message','jour','type'));
		}
		
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EnfantsRequest $request)
	{
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, EnfantsRequest $request)
	{
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
	}

}

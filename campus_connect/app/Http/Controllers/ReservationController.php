<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Models\Reservation;
use App\Models\Salle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $policyResponse = Gate::inspect('create', Reservation::class);
        if ($policyResponse->denied()) {
            return redirect()->route('reservations.index')->with('error', $policyResponse->message());
        }
        $salles=Salle::all();
        $equipements = Equipement::all();
        return view('reservations.create', compact('salles','equipements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'salle_id' => 'nullable',
            "equipement_id" => "nullable",
            'start_date' => 'required|date',
            'end_date' => 'required|date|',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

       /* $validator->after(function ($validator) use ($request){

        });*/

        $reservation = new Reservation();
        if ($request->has('salle_id')) {
            $reservation->salle_id = $request->input('salle_id');
        }
        if ($request->has('equipement_id')) {
            $reservation->equipement_id = $request->input('equipement_id');
        }
        $reservation->user_id = $request->user()->id;
        $reservation->date_debut = $request->input("start_date");
        $reservation->date_fin = $request->input('end_date');
        $reservation->motif = $request->input('description');
        $reservation->statut = 'en_attente';
        $reservation->save();
        
        return redirect()->route('reservations.index')->with('success', 'Réservation créée avec succès et en attente de validation.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
        $dummyReservation=$reservation;
        if ($dummyReservation){
            $user = User::find($dummyReservation->user_id);
            $dummyReservation->user = User::find($dummyReservation->user_id);
            if (Salle::find($dummyReservation->salle_id)){
                $salle = Salle::find($dummyReservation->salle_id);
                $dummyReservation->salle = $salle;
            }
            if (Equipement::find($dummyReservation->equipement_id)){
                $equipement = Equipement::find($dummyReservation->equipement_id);
                $dummyReservation->equipement = $equipement;
            }
            return view('reservations.show', compact('dummyReservation'));
        }
        return redirect()->route('reservations.index')->with('error', 'Réservation non trouvée.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
        return view('reservations.form', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    public function accpteReservation(Request $request, Reservation $reservation)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $validator->after(function ($validator) use ($request){
            $statut = $request->input('statut');
            if ($statut !== 'valide') {
                $validator->errors()->add('statut', 'Le statut doit être "validée" pour accepter une réservation.');
            }
        });
        $reservation->statut = 'valide';
        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Réservation accepté avec succès.');
    }
    public function refuseReservation(Request $request, Reservation $reservation)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $validator->after(function ($validator) use ($request){
            $statut = $request->input('statut');
            if ($statut !== 'rejete') {
                $validator->errors()->add('statut', 'Le statut doit être "rejete" pour refuser une réservation.');
            }
        });
        $reservation->statut = 'rejete';
        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Réservation rejetée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
        $policyResponse = Gate::inspect('delete', $reservation);
        if ($policyResponse->denied()) {
            return redirect()->route('reservations.index')->with('error', $policyResponse->message());
        }   
        if ($reservation){
            $reservation->delete();
            return redirect()->route('reservations.index')->with('success', 'Réservation supprimée avec succès.');
        }
        return redirect()->route('reservations.index')->with('error', 'Réservation non trouvée.');
    }
}
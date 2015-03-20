<?php namespace App\Http\Controllers;

use App\Journey;
use Excel;
use App\Http\Requests;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MileageController extends Controller {

	protected $client;

	function __construct( Client $client )
	{
		$this->client = $client;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view( 'mileage.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function store( Request $request )
	{
		$file = $request->file( 'mileage' );
		$file->move( storage_path( 'mileage/staff_id/bc' ), 'bc.xlsx' );
		$dir     = storage_path( 'mileage/staff_id/bc/bc.xlsx' );
		$mileage = Excel::load( $dir, function ( $reader ) { } )->get();
		$batchRef = 'TP_ID_1_'.time();
		foreach ( $mileage as $journey )
		{
			$entry = new Journey();
			foreach ( $entry->getFillable() as $property )
			{
				$entry->{$property} = $journey->{$property};
			}
			$entry->user_id = 1;
			$entry->batch = $batchRef;

			$destinations = '';
			foreach ( $entry->getDestinationFields() as $field )
			{
				if ( $entry->{$field} != null )
				{
					$destinations .= htmlentities( $entry->{$field} . '+uk|' );
				}
			}

			$journeyPoints = $entry->getJourneyPoints();

			$query      = "https://maps.googleapis.com/maps/api/directions/json?origin={$entry->from}+uk&destination={$journeyPoints['end']}+uk&waypoints={$journeyPoints['waypoints']}&sensor=false&&units=imperial&key=AIzaSyBw3sbZtDnDQkqNZDVS53YGMSv4TwNV_rM";
			$directions = $this->client->get( $query );
			$distance = 0;
			foreach ( $directions->json()['routes'][0]['legs'] as $leg )
			{
				$distance += (float) $leg['distance']['text'];
			}

			$entry->distance_matrix = $distance;
			$entry->save();
		}

		dd( 'Done' );

		return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show( $id )
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit( $id )
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update( $id )
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy( $id )
	{
		//
	}

}

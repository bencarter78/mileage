<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model {

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'user_id',
		"journey_date",
		"from",
		"dest1",
		"dest2",
		"dest3",
		"dest4",
		"dest5",
		"dest6",
		"reason",
		"type",
		"mileage",
		"other_description",
		"other_amount",
		"salary_sacrifice"
	];

	/**
	 * @var array
	 */
	protected $destinationFields = [
		"dest1",
		"dest2",
		"dest3",
		"dest4",
		"dest5",
		"dest6"
	];

	/**
	 * @return array
	 */
	public function getDestinationFields()
	{
		return $this->destinationFields;
	}

	/**
	 * @return mixed
	 */
	public function getDestination()
	{
		foreach ( array_reverse( $this->getDestinationFields() ) as $location )
		{
			if ( $this->{$location} != null )
			{
				return $this->{$location};
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getJourneyPoints()
	{
		$destinations = array_reverse( $this->getDestinationFields() );
		foreach ( $destinations as $key => $location )
		{
			if ( $this->{$location} != null )
			{
				$journey['end'] = $this->{$location};
				unset( $destinations[ $key ] );
				break;
			}
			unset( $destinations[ $key ] );
		}

		$destinations = array_reverse( $destinations );

		$waypoints = '';
		foreach ( $destinations as $location )
		{
			$waypoints .= htmlentities( $this->{$location} . '+uk|' );
		}
		$journey['waypoints'] = substr( $waypoints, 0, - 1 );

		return $journey;
	}

}

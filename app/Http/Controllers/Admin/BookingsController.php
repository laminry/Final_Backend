<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Bookings;
use App\Http\Requests\CreateBookingsRequest;
use App\Http\Requests\UpdateBookingsRequest;
use Illuminate\Http\Request;

use App\Rooms;


class BookingsController extends Controller {


		protected $booking;

		public function __construct(Bookings $getbookings)
	   {
	     $this ->bookings = $getbookings;
	   }

	////////-------------------------- FIND ALL BOOKING ---------------------------------/////
	////////----- API
	public function allbookings()
{
$booking = $this->bookings->all();
return $booking;
}
////////----- WEB
	public function index(Request $request)
    {
        $bookings = Bookings::with("rooms")->get();

		return view('admin.bookings.index', compact('bookings'));
	}

	////////-------------------------- FIND SINGLE ROOM ---------------------------------/////
		public function getbookingid($bookingid)
		{
		$booking = $this->bookings->find($bookingid);
		return $booking;
		}


		////////-------------------------- POST A ROOM ---------------------------------/////
			////////----- API
			public function postbooking(Request $request)
			 {
				 $booking =[
					 "name"  => $request->name,
					 "email"  => $request->email,
					 "passid" => $request->passid,
					 "rooms_id" => $request->room_id,
					 "checkin" => $request->checkin,
					 "checkout" => $request->checkout,
					 "noadults" => $request->noadults,
					 "nochildren" => $request->nochildren,
					 "additional" => $request->additional];
					 $this->bookings->create($booking);
				 return response(['successfully Posted'],200);
			 }

			 ////////----- WEB
	public function create()
	{
	    $rooms = Rooms::pluck("roomtype", "id")->prepend('Please select', 0);


	    return view('admin.bookings.create', compact("rooms"));
	}

	public function store(CreateBookingsRequest $request)
	{

		Bookings::create($request->all());

		return redirect()->route(config('quickadmin.route').'.bookings.index');
	}

	///////-------------------------- EDIT A ROOM  ---------------------------------/////
	////////----- API
	public function updatebooking(Request $request, $bookingid)
	{
		$room = $this->bookings->find($bookingid);
		$room->name = $request->name;
		$room->email = $request->email;
		$room->passid = $request->passid;
		$room->rooms_id = $request->rooms_id;
		$room->checkin = $request->checkin;
		$room->checkout = $request->checkout;
		$room->noadults = $request->noadults;
		$room->nochildren = $request->nochildren;
		$room->additional = $request->additional;
		$room = $room->save();
		return response(['successfully Updated'],200);

	}

	////////----- WEB
	public function edit($id)
	{
		$bookings = Bookings::find($id);
	    $rooms = Rooms::pluck("roomtype", "id")->prepend('Please select', 0);


		return view('admin.bookings.edit', compact('bookings', "rooms"));
	}


	public function update($id, UpdateBookingsRequest $request)
	{
		$bookings = Bookings::findOrFail($id);



		$bookings->update($request->all());

		return redirect()->route(config('quickadmin.route').'.bookings.index');
	}

	////////-------------------------- DELETE SPECIFICIED ROOM  ---------------------------------/////
		//////// API
			public function deletebooking($bookingid)
			{
			$room = $this->bookings->find($bookingid)->delete();
			return response(['successfully deleted'],200);

		}
		//////// WEB
	public function destroy($id)
	{
		Bookings::destroy($id);

		return redirect()->route(config('quickadmin.route').'.bookings.index');
	}

	////////-------------------------- DELETE ALL ROOM (WEB)  ---------------------------------/////

    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Bookings::destroy($toDelete);
        } else {
            Bookings::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.bookings.index');
    }

}

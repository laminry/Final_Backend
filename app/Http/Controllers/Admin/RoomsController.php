<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Rooms;
use App\Bookings;
use App\Http\Requests\CreateRoomsRequest;
use App\Http\Requests\UpdateRoomsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class RoomsController extends Controller {

		protected $room;
	  protected $booking;

		public function __construct(Rooms $getrooms)
	   {
	     $this ->room = $getrooms;
	   }

	////////-------------------------- FIND ALL ROOM ---------------------------------/////
	////////----- API
		 public function allroom()
		 {
		$room = $this->room->all();
		return $room;
	}
	////////----- WEB
	public function index(Request $request)
    {
        $rooms = Rooms::all();

		return view('admin.rooms.index', compact('rooms'));
	}

	////////-------------------------- FIND SINGLE ROOM ---------------------------------/////
public function getroomid($roomid)
{
$room = $this->room->find($roomid);
return $room;
}


////////-------------------------- POST A ROOM ---------------------------------/////
////////----- API
public function postroom(Request $request)
 {
	 $room =["roomtype"  => $request->roomtype,
		 "image"  => $request->image,
		 "description" => $request->description,
		 "checkin" => $request->checkin,
		 "checkout" => $request->checkout,
		 "price" => $request->price];
		 $this->room->create($room);
	 // $room = $this->room->create($room);

	 return response(['successfully Posted',],200);
 }


 ////////----- WEB
	public function create()
	{
	    return view('admin.rooms.create');
	}

	public function store(CreateRoomsRequest $request)
	{

		Rooms::create($request->all());

		return redirect()->route(config('quickadmin.route').'.rooms.index');
	}

	////////-------------------------- EDIT A ROOM  ---------------------------------/////
////////----- API
public function updateroom(Request $request, $roomid)
{
	$room= $this->room->find($roomid);
	$room->roomtype = $request->roomtype;
	$room->image = $request->image;
	$room->description = $request->description;
	$room->checkin = $request->checkin;
	$room->checkout = $request->checkout;
	$room->price = $request->price;
	$room = $room->save();
	return response(['successfully Updated'],200);

}

////////----- WEB
	public function edit($id)
	{
		$rooms = Rooms::find($id);


		return view('admin.rooms.edit', compact('rooms'));
	}

	public function update($id, UpdateRoomsRequest $request)
	{
		$rooms = Rooms::findOrFail($id);



		$rooms->update($request->all());

		return redirect()->route(config('quickadmin.route').'.rooms.index');
	}

	///////-------------------------- DELETE SPECFICIED ROOM  ---------------------------------/////
	//////// API
		public function deleteroom($roomid)
		{
		$room = $this->room->find($roomid)->delete();
		return response(['successfully deleted'],200);

	}
	//////// WEB
	public function destroy($id)
	{
		Rooms::destroy($id);

		return redirect()->route(config('quickadmin.route').'.rooms.index');
	}


////////-------------------------- DELETE ALL ROOM (WEB)  ---------------------------------/////
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Rooms::destroy($toDelete);
        } else {
            Rooms::whereNotNull('id')->delete();
        }

        return redirect()->route(config('quickadmin.route').'.rooms.index');
    }

		////////-------------------------- FIND FREE ROOMS ---------------------------------/////
public function availablerooms(Request $request)
{
	$this->booking = new Bookings();
	$checkInDate = $request->checkin;
	$checkOutDate = $request->checkout;
	try{
      $room = $this->booking
      ->join('rooms', 'rooms.id', '=', 'bookings.id')
      ->whereBetween('bookings.checkin', [$checkInDate, $checkOutDate])
      ->whereBetween('bookings.checkout', [$checkInDate, $checkOutDate])
      ->select('bookings.id')
      ->get();
      // return $room;
      $displayroom = $this->room->whereNotIn('id', $room)->get();
      return response()->json($displayroom, 200);
    }
    catch(\Exceptions $e) {
      return response([$e->getMessage()]);
    }
}

}

package com.shindygo.shindy;


import android.Manifest;
import android.content.Context;
import android.content.DialogInterface;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.LocationManager;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.Fragment;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.google.android.gms.common.GooglePlayServicesNotAvailableException;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapView;
import com.google.android.gms.maps.MapsInitializer;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.shindygo.shindy.model.EventInvite;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link EventDetailsFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class EventDetailsFragment extends Fragment implements OnMapReadyCallback {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private static final String TAG = EventDetailsFragment.class.getSimpleName();
    private static final LatLng DISNEY = new LatLng(33.809742,-117.915542);
 //  LocationManager locationManager;
  //  String provider;
    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;
    private EventInvite eventInvite;
    GoogleMap googleMap;
    MapView mapView;
    TextView tvDate;
    TextView tvLocation;
    TextView tvPrice;
    TextView tvDescription;
    TextView tvExpires;
    TextView tvWebsite;

    public EventDetailsFragment() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param eventInvite Parameter 1.
     * @return A new instance of fragment EventDetailsFragment.
     */
    // TODO: Rename and change types and number of parameters
    public static EventDetailsFragment newInstance(EventInvite eventInvite) {
        EventDetailsFragment fragment = new EventDetailsFragment();
        Bundle args = new Bundle();
       // args.putSerializable(ARG_PARAM1, eventInvite);
        fragment.setArguments(args);
        fragment.eventInvite = eventInvite;
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
           // eventInvite = (EventInvite) getArguments().getSerializable(ARG_PARAM1);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.events_details_content, container, false);

     //   locationManager = (LocationManager) getContext().getSystemService(Context.LOCATION_SERVICE);

       // provider = locationManager.getBestProvider(new Criteria(), false);

        initVIews(view);
        mapView.onCreate(savedInstanceState);


        if (eventInvite == null) {
            Log.v(TAG, "null event");
            return view;
        }
        setContent();

        return view;
    }

    private void setContent() {
        tvDate.setText(getString(R.string.date_n,
                getText(eventInvite.getSchedStartDate()), getText(eventInvite.getStartTime())));
        tvLocation.setText(getString(R.string.location_n,
                getText(eventInvite.getAddress())));
        tvPrice.setText(getString(R.string.price_n,
                getText(eventInvite.getTicketPrice())));
        tvExpires.setText(getString(R.string.expires_n,
                getText(eventInvite.getExpiryDate())));
        tvDescription.setText(getText(eventInvite.getDescription()));
        tvWebsite.setText(getString(R.string.website_n,
                getText(eventInvite.getWebsiteUrl())));
    }


    private String getText(String text) {
        try {
            return text;
        } catch (NullPointerException e) {
            e.printStackTrace();
        }
        return "";
    }

    private void initVIews(View view) {
        tvDate = view.findViewById(R.id.tvDate);
        tvLocation = view.findViewById(R.id.tvLocation);
        tvPrice = view.findViewById(R.id.tvPrice);
        tvDescription = view.findViewById(R.id.tvDescription);
        tvExpires = view.findViewById(R.id.tvExpires);
        tvWebsite = view.findViewById(R.id.tvWebsite);
        mapView = view.findViewById(R.id.mapView);
        mapView.getMapAsync(this);

    }

    @Override
    public void onMapReady(GoogleMap map) {

        googleMap = map;
        // Gets to GoogleMap from the MapView and does initialization stuff
        googleMap.getUiSettings().setMyLocationButtonEnabled(false);
        if (ActivityCompat.checkSelfPermission(getActivity(),
                Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED
                && ActivityCompat.checkSelfPermission(getActivity(),
                Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            Log.v(TAG, "no permission");
            checkLocationPermission();
            return;
        }else {
            googleMap.setMyLocationEnabled(true);
            // Needs to call MapsInitializer before doing any CameraUpdateFactory calls
            MapsInitializer.initialize(this.getActivity());

            drawMarker();

        }




    }

    private void drawMarker() {
        if (googleMap != null) {
            // Add some markers to the map, and add a data object to each marker.
            LatLng latLng = new LatLng(0, 0);
            if(eventInvite==null){
                Log.v(TAG,"eventInvite==null");

                return;
            }
            try {
                Log.v(TAG,"eventName: "+eventInvite.getEventName() + " "+
                                            eventInvite.getLat() + " "+ eventInvite.getLongitude());

                latLng = new LatLng(Double.parseDouble(eventInvite.getLat()),
                        Double.parseDouble(eventInvite.getLongitude()));

            } catch (Exception e) {
                e.printStackTrace();
            }
            googleMap.clear();
            googleMap.addMarker(new MarkerOptions()
                    .position(DISNEY)
                    .title(eventInvite.getEventName())
                    .snippet(eventInvite.getAddress()));
            googleMap.animateCamera(CameraUpdateFactory.newLatLngZoom(DISNEY, 12));
        }

    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        mapView.onDestroy();
    }

    @Override
    public void onResume() {
        try {
            mapView.onResume();

        }catch (NullPointerException e){
            e.printStackTrace();
        }
        super.onResume();
/*        if (ContextCompat.checkSelfPermission(getActivity(),
                Manifest.permission.ACCESS_FINE_LOCATION)
                == PackageManager.PERMISSION_GRANTED) {

            //locationManager.requestLocationUpdates(provider, 400, 1, this);
        }*/
    }

    @Override
    public void onPause() {
        super.onPause();
        mapView.onPause();
/*        if (ContextCompat.checkSelfPermission(getActivity(),
                Manifest.permission.ACCESS_FINE_LOCATION)
                == PackageManager.PERMISSION_GRANTED) {

           // locationManager.removeUpdates(this);
        }*/
    }
    @Override
    public void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        mapView.onSaveInstanceState(outState);
    }

    @Override
    public void onLowMemory() {
        super.onLowMemory();
        mapView.onLowMemory();
    }

    public static final int MY_PERMISSIONS_REQUEST_LOCATION = 99;

    public boolean checkLocationPermission() {
        if (ContextCompat.checkSelfPermission(getActivity(),
                Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {

            // Should we show an explanation?
            if (ActivityCompat.shouldShowRequestPermissionRationale(getActivity(),
                    Manifest.permission.ACCESS_FINE_LOCATION)) {

                // Show an explanation to the user *asynchronously* -- don't block
                // this thread waiting for the user's response! After the user
                // sees the explanation, try again to request the permission.
                new AlertDialog.Builder(getActivity())
                        .setTitle(R.string.title_location_permission)
                        .setMessage(R.string.text_location_permission)
                        .setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialogInterface, int i) {
                                //Prompt the user once explanation has been shown
                                ActivityCompat.requestPermissions(getActivity(),
                                        new String[]{Manifest.permission.ACCESS_FINE_LOCATION},
                                        MY_PERMISSIONS_REQUEST_LOCATION);
                            }
                        })
                        .create()
                        .show();


            } else {
                // No explanation needed, we can request the permission.
                ActivityCompat.requestPermissions(getActivity(),
                        new String[]{Manifest.permission.ACCESS_FINE_LOCATION},
                        MY_PERMISSIONS_REQUEST_LOCATION);
            }
            return false;
        } else {
            return true;
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode,
                                           String permissions[], int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSIONS_REQUEST_LOCATION: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {

                    // permission was granted, yay! Do the
                    // location-related task you need to do.
                    if (ContextCompat.checkSelfPermission(getActivity(),
                            Manifest.permission.ACCESS_FINE_LOCATION)
                            == PackageManager.PERMISSION_GRANTED) {

                        //Request location updates:
                       // locationManager.requestLocationUpdates(provider, 400, 1, this);
                        drawMarker();
                    }

                } else {

                    // permission denied, boo! Disable the
                    // functionality that depends on this permission.

                }
                return;
            }

        }
    }

}

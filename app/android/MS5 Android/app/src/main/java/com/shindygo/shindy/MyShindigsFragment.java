package com.shindygo.shindy;

import android.app.ActivityOptions;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.shindygo.shindy.interfaces.Click;
import com.shindygo.shindy.adapter.MyShindingsAdapter;
import com.shindygo.shindy.model.Event;
import com.shindygo.shindy.model.EventInvite;
import com.shindygo.shindy.model.User;
import com.shindygo.shindy.utils.Cache;

import java.util.ArrayList;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.Unbinder;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link MyShindigsFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class MyShindigsFragment extends Fragment implements SwipeRefreshLayout.OnRefreshListener {

    private static final String TAG = MyShindigsFragment.class.getSimpleName();
    @BindView(R.id.rv_shindings_attending)
    RecyclerView rvShindingsAttending;
    @BindView(R.id.rv_shindings_invited)
    RecyclerView rvShindingsInvited;
    Unbinder unbinder;
    @BindView(R.id.tv_invite)
    TextView tvInvite;
    @BindView(R.id.linearLayout)
    LinearLayout linearLayout;
    @BindView(R.id.linearLayout2)
    LinearLayout linearLayout2;
   /* @BindView(R.id.list_item_profile)
    TextView listItemProfile;
    @BindView(R.id.ll_details)
    LinearLayout llDetails;
    @BindView(R.id.star_favorite)
    ImageView starFavorite;
    @BindView(R.id.list_item_favorite)
    TextView listItemFavorite;*/
/*    @BindView(R.id.ll_invited)
    LinearLayout llInvited;
    @BindView(R.id.list_item_invite)
    TextView listItemInvite;
    @BindView(R.id.list_item_message)
    TextView listItemMessage;
    @BindView(R.id.ll_invite)
    LinearLayout llInvite;
    @BindView(R.id.bar)
    LinearLayout bar;*/

    SwipeRefreshLayout mSwipeRefreshLayout;


    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private OnFragmentInteractionListener mListener;

    public MyShindigsFragment() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment MyShindigsFragment.
     */
    // TODO: Rename and change types and number of parameters
    public static MyShindigsFragment newInstance(String param1, String param2) {
        MyShindigsFragment fragment = new MyShindigsFragment();
        Bundle args = new Bundle();
      //  args.putString(ARG_PARAM1, param1);
       // args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
           // mParam1 = getArguments().getString(ARG_PARAM1);
            //mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_my_shindigs, container, false);
        unbinder = ButterKnife.bind(this, view);

        rvShindingsAttending.setLayoutManager(new LinearLayoutManager(getActivity()));

        rvShindingsAttending.setNestedScrollingEnabled(false);
        rvShindingsInvited.setLayoutManager(new LinearLayoutManager(getActivity()));
        rvShindingsInvited.setNestedScrollingEnabled(false);
        tvInvite.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

            }
        });

        rvShindingsAttending.setHasFixedSize(true);//every item of the RecyclerView has a fix size
        rvShindingsAttending.setLayoutManager(new LinearLayoutManager(getContext()));
        rvShindingsInvited.setHasFixedSize(true);//every item of the RecyclerView has a fix size
        rvShindingsInvited.setLayoutManager(new LinearLayoutManager(getContext()));



        // SwipeRefreshLayout
        mSwipeRefreshLayout = (SwipeRefreshLayout) view.findViewById(R.id.swipe_container_invited);
        mSwipeRefreshLayout.setOnRefreshListener(this);
        mSwipeRefreshLayout.setColorSchemeResources(R.color.colorPrimary,
                android.R.color.holo_green_dark,
                android.R.color.holo_orange_dark,
                android.R.color.holo_blue_dark);

        /**
         * Showing Swipe Refresh animation on activity create
         * As animation won't start on onCreate, post runnable is used
         */
        mSwipeRefreshLayout.post(new Runnable() {

            @Override
            public void run() {

                mSwipeRefreshLayout.setRefreshing(true);

                // Fetching data from server
                loadRecyclerViewData();

            }
        });
        rvShindingsInvited.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrolled(RecyclerView recyclerView, int dx, int dy) {
                if (((LinearLayoutManager)recyclerView.getLayoutManager()).findFirstCompletelyVisibleItemPosition() == 0)
                    mSwipeRefreshLayout.setEnabled(true);
                else
                    mSwipeRefreshLayout.setEnabled(false);
            }
        });
        if(Cache.getMyAttendingEventsList().size()>0)
        //listEvents(Arrays.asList(((EventInvite[]) Cache.getMyAttendingEventsList().values().toArray())),rvShindingsAttending);
         listEvents(Cache.getEventsAsList(Cache.getMyAttendingEventsList()),rvShindingsAttending);
        if(Cache.getMyInvitedEventsList().size()>0)
          listEvents(Cache.getEventsAsList(Cache.getMyInvitedEventsList()),rvShindingsInvited);

        //listEvents(Arrays.asList(((EventInvite[]) Cache.getMyInvitedEventsList().values().toArray())),rvShindingsInvited);
        return view;
    }

    /**
     * Called when a swipe gesture triggers a refresh.
     */
    @Override
    public void onRefresh() {
    // Fetching data from server
        loadRecyclerViewData();
        Log.v(TAG, "swipe refresh");

    }
    // Call when the a network service is done. We should re-enable
// swipe-to-refresh as now we allow user to refresh it.
    public void hideRefreshProgressBar() {
        if (mSwipeRefreshLayout != null &&
                mSwipeRefreshLayout.isRefreshing()) {
            mSwipeRefreshLayout.post(new Runnable() {
                @Override
                public void run() {
                    mSwipeRefreshLayout.setRefreshing(false);
                    mSwipeRefreshLayout.setEnabled(true);
                }
            });
        }
    }

    private void loadRecyclerViewData() {
        // Showing refresh animation before making http call
        mSwipeRefreshLayout.setRefreshing(true);

        final Api api = new Api(getContext());
        api.fetchAttendingEvents(User.getCurrentUserId(),new Callback<List<EventInvite>>() {
            @Override
            public void onResponse(Call<List<EventInvite>> call, Response<List<EventInvite>> response) {
                List<EventInvite> eventsList = new ArrayList<>();
                Log.v(TAG, response.toString());

                if (response.body()!=null)
                    eventsList = response.body();

                Log.i(TAG, response.message());
                Log.v(TAG, "list size; "+ eventsList.size());
                try {

                    listEvents(eventsList, rvShindingsAttending);
                    Cache.setMyAttendingEventsList(eventsList);
                }catch (NullPointerException e){
                    e.printStackTrace();
                }

            }

            @Override
            public void onFailure(Call<List<EventInvite>> call, Throwable t) {
                /*users.clear();
                adapter.notifyDataSetChanged();*/
                Log.e(TAG, "failed");
                t.printStackTrace();
            }
        });

        api.fetchInvitedEvents(User.getCurrentUserId(),new Callback<List<EventInvite>>() {
            @Override
            public void onResponse(Call<List<EventInvite>> call, Response<List<EventInvite>> response) {
                List<EventInvite> eventsList = new ArrayList<>();
                Log.v(TAG, response.toString());
                if (response.body()!=null)
                    eventsList = response.body();
                Log.i(TAG, response.message());
                Log.v(TAG, "list size; "+ eventsList.size());
                try {
                    listEvents(eventsList, rvShindingsInvited);
                    Cache.setMyInvitedEventsList(eventsList);
                    mSwipeRefreshLayout.setRefreshing(false);
                    mSwipeRefreshLayout.setEnabled(true);
                    hideRefreshProgressBar();
                }catch (NullPointerException e){
                    e.printStackTrace();

                }
            }

            @Override
            public void onFailure(Call<List<EventInvite>> call, Throwable t) {
                /*users.clear();
                adapter.notifyDataSetChanged();*/
                Log.e(TAG, "failed");
                t.printStackTrace();
                mSwipeRefreshLayout.setRefreshing(false);
                mSwipeRefreshLayout.setEnabled(true);

            }
        });

    }

    private void listEvents(List<EventInvite> eventsList, RecyclerView rv) {

/*        DividerItemDecoration dividerItemDecoration = new DividerItemDecoration(rv.getContext(),
                ((LinearLayoutManager) rv.getLayoutManager()).getOrientation());
        rv.addItemDecoration(dividerItemDecoration);*/
        MyShindingsAdapter adapter = new MyShindingsAdapter(eventsList, rv.getContext(), new Click<Event>() {
            @Override
            public void onClick(int id, View view, Event event) {
                switch (id){
                    case R.id.ll_details:{
/*
                        Intent intent = new Intent(getActivity(), EventDetailsActivity.class);
                        // create the transition animation - the images in the layouts
                        // of both activities are defined with android:transitionName="robot"
                        ActivityOptions options = null;
                        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP) {
                            options = ActivityOptions
                                    .makeSceneTransitionAnimation(getActivity(), view, getString(R.string.transition_event_image));
                            // start the new activity
                            startActivity(intent, options.toBundle());
                        }else{
                            // start the new activity
                            startActivityForResult(intent,0);
                            getActivity().overridePendingTransition( R.anim.left_out, R.anim.left_in );
                        }

*/
                        EventDetailsActivity.navigate((AppCompatActivity) getActivity(), view, (EventInvite) event);
/*
                        Intent intent = new Intent(getActivity(), EventDetailsActivity.class);
                        startActivity(intent);
                        getActivity().overridePendingTransition( R.anim.left_out, R.anim.left_in );
*/

                        break;
                    }
                    case R.id.ll_invite:{



                        break;
                    }
                    case R.id.ll_invited:{



                        break;
                    }
                }
            }
        });
        //rvShindingsAttending.setLayoutManager(layoutManager);

        rv.setAdapter(adapter);
    }

    // TODO: Rename method, update argument and hook method into UI event
    public void onButtonPressed(Uri uri) {
        if (mListener != null) {
            mListener.onFragmentInteraction(uri);
        }
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
  /*      if (context instanceof OnFragmentInteractionListener) {
            mListener = (OnFragmentInteractionListener) context;
        } else {
            throw new RuntimeException(context.toString()
                    + " must implement OnFragmentInteractionListener");
        }*/
    }



    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        unbinder.unbind();
    }


    /**
     * This interface must be implemented by activities that contain this
     * fragment to allow an interaction in this fragment to be communicated
     * to the activity and potentially other fragments contained in that
     * activity.
     * <p>
     * See the Android Training lesson <a href=
     * "http://developer.android.com/training/basics/fragments/communicating.html"
     * >Communicating with Other Fragments</a> for more information.
     */
    public interface OnFragmentInteractionListener {
        // TODO: Update argument type and name
        void onFragmentInteraction(Uri uri);
    }
}

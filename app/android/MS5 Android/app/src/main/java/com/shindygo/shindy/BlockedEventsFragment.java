package com.shindygo.shindy;

import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;


import com.shindygo.shindy.adapter.MyBlockedEventsAdapter;
import com.shindygo.shindy.interfaces.Click;
import com.shindygo.shindy.model.EventInvite;
import com.shindygo.shindy.model.User;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class BlockedEventsFragment extends Fragment {
    private static final String TAG = BlockedEventsFragment.class.getSimpleName();

    // TODO: Customize parameter argument names
    private static final String ARG_COLUMN_COUNT = "column-count";
    // TODO: Customize parameters
    private int mColumnCount = 1;
    List<EventInvite> list = new ArrayList<>();
    RecyclerView rv;

    /**
     * Mandatory empty constructor for the fragment manager to instantiate the
     * fragment (e.g. upon screen orientation changes).
     */
    public BlockedEventsFragment() {
    }

    // TODO: Customize parameter initialization
    @SuppressWarnings("unused")
    public static BlockedEventsFragment newInstance(int columnCount) {
        BlockedEventsFragment fragment = new BlockedEventsFragment();
        Bundle args = new Bundle();
        args.putInt(ARG_COLUMN_COUNT, columnCount);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if (getArguments() != null) {
            mColumnCount = getArguments().getInt(ARG_COLUMN_COUNT);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_blocked_events, container, false);

        // Set the adapter
        if (view instanceof RecyclerView) {
            Context context = view.getContext();
            rv = (RecyclerView) view;
            rv.setLayoutManager(new LinearLayoutManager(context));

        }
        loadRecyclerViewData();

        return view;
    }


    private void loadRecyclerViewData() {
        // Showing refresh animation before making http call
        // mSwipeRefreshLayout.setRefreshing(true);

        final Api api = Api.getInstance();
        api.fetchBlockedEvents(User.getCurrentUserId(), new Callback<List<EventInvite>>() {
            @Override
            public void onResponse(Call<List<EventInvite>> call, Response<List<EventInvite>> response) {
                List<EventInvite> eventsList = new ArrayList<>();
                Log.v(TAG, response.toString());

                if (response.body() != null)
                    eventsList = response.body();

                Log.i(TAG, response.message());
                Log.v(TAG, "list size; " + eventsList.size());
                try {

                    listEvents(eventsList, rv);
                } catch (NullPointerException e) {
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


    }

    private void listEvents(List<EventInvite> eventsList, RecyclerView rv) {

        MyBlockedEventsAdapter adapter = new MyBlockedEventsAdapter(eventsList, rv.getContext(),
                new Click<EventInvite>() {
                    @Override
                    public void onClick(int id, View view, EventInvite event) {
                        switch (id) {
                            case R.id.ll_details: {
                                String json = event.toJSON();
                                Log.v(TAG, json);
                                Bundle args = new Bundle();
                                args.putString(EventActivity.EXTRA_MODEL, json);
                                args.putString(EventActivity.EXTRA_EVENT_ID, event.getEventId());

                                FragmentManager fm = getActivity().getSupportFragmentManager();
                                Fragment fragment = new EventActivity();
                                fragment.setArguments(args);
                                fm.beginTransaction()
                                        .replace(R.id.frame, fragment)
                                        .addToBackStack("my_fragment")
                                        .commit();

                                break;
                            }
                            case R.id.ll_invite: {


                                break;
                            }
                            case R.id.ll_invited: {


                                break;
                            }
                        }
                    }
                });
        rv.setAdapter(adapter);


    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
    }


    @Override
    public void onDetach() {
        super.onDetach();
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
    }
}

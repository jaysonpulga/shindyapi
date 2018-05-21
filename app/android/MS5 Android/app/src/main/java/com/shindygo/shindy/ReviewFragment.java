package com.shindygo.shindy;

import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.shindygo.shindy.interfaces.Comment;
import com.shindygo.shindy.model.Review;

import java.util.ArrayList;
import java.util.List;

/**
 * A fragment representing a list of Items.
 * <p/>
 */
public class ReviewFragment extends Fragment {

    // TODO: Customize parameter argument names
    private static final String ARG_EVENT_ID = "event_id";

    List<Review> reviewList;
    String eventId;
    RecyclerView recyclerView;

    /**
     * Mandatory empty constructor for the fragment manager to instantiate the
     * fragment (e.g. upon screen orientation changes).
     */
    public ReviewFragment() {
    }

    // TODO: Customize parameter initialization
    @SuppressWarnings("unused")
    public static ReviewFragment newInstance(String eventId) {
        ReviewFragment fragment = new ReviewFragment();
        Bundle args = new Bundle();
        args.putString(ARG_EVENT_ID, eventId);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if (getArguments() != null) {
            eventId = getArguments().getString(ARG_EVENT_ID);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_review_list, container, false);

        // Set the adapter
        if (view instanceof RecyclerView) {
            Context context = view.getContext();
            recyclerView = (RecyclerView) view;
            populateList(reviewList);
            recyclerView.setLayoutManager(new LinearLayoutManager(context));

            recyclerView.setAdapter(new ReviewRecyclerViewAdapter(reviewList, getActivity()));
        }
        return view;
    }

    private void populateList(List<Review> reviewList) {
        if(reviewList==null){
            this.reviewList = new ArrayList<>();
            this.reviewList.add(new Review("22","2","4","4","very nice"));
        }else {this.reviewList = reviewList;}

    }


    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
    }

    @Override
    public void onDetach() {
        super.onDetach();
    }


}

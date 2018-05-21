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

import com.shindygo.shindy.interfaces.Click;
import com.shindygo.shindy.adapter.DiscussionRecyclerViewAdapter;
import com.shindygo.shindy.interfaces.Comment;
import com.shindygo.shindy.model.Discussion;

import java.util.ArrayList;
import java.util.List;

/**
 * A fragment representing a list of Items.
 * <p/>

 */
public class DiscussionFragment extends Fragment {

    // TODO: Customize parameter argument names
    private static final String ARG_EVENT_ID = "event_id";
    private static final String ARG_USER_ID = "event_user_id";

    // TODO: Customize parameters
    private String eventId;
    private String userFbId;

    private List<Comment> discussionList;
    private RecyclerView rvList;


    /**
     * Mandatory empty constructor for the fragment manager to instantiate the
     * fragment (e.g. upon screen orientation changes).
     */
    public DiscussionFragment() {
    }

    // TODO: Customize parameter initialization
    @SuppressWarnings("unused")
    public static DiscussionFragment newInstance(String eventId, String userFbId) {
        DiscussionFragment fragment = new DiscussionFragment();
        Bundle args = new Bundle();
        args.putString(ARG_EVENT_ID, eventId);
        args.putString(ARG_USER_ID, userFbId);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if (getArguments() != null) {
            eventId = getArguments().getString(ARG_EVENT_ID);
            userFbId = getArguments().getString(ARG_USER_ID);

        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_discussion_list, container, false);
        rvList = view.findViewById(R.id.rvList);
        notifydatachanged(discussionList);
        return view;
    }

    private void notifydatachanged(List<Comment> discussionList) {
        if(discussionList==null){
            this.discussionList = new ArrayList<>();
            this.discussionList.add(new Discussion("1","1","wasak"));
            this.discussionList.add(new Discussion("1","1","wasak na wasak"));

            //return;
        }else{        this.discussionList =discussionList;}
        // Set the adapter
        rvList.setLayoutManager(new LinearLayoutManager(getContext()));
        rvList.setAdapter(new DiscussionRecyclerViewAdapter( this.discussionList, getContext(), new Click<Comment>() {
            @Override
            public void onClick(int id, View view, Comment discussion) {
                /****
                 * TODO
                 */
            }
        }));
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

package com.shindygo.shindy;

import android.animation.AnimatorSet;
import android.animation.ObjectAnimator;
import android.animation.PropertyValuesHolder;
import android.animation.ValueAnimator;
import android.content.Context;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.support.design.widget.Snackbar;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.shindygo.shindy.interfaces.ClickCard;
import com.shindygo.shindy.interfaces.ClickShowPopup;
import com.shindygo.shindy.adapter.NewUserCardAdapter;
import com.shindygo.shindy.model.User;
import com.yuyakaido.android.cardstackview.CardStackView;
import com.yuyakaido.android.cardstackview.SwipeDirection;

import org.json.JSONObject;

import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.content.Context.LAYOUT_INFLATER_SERVICE;

/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link NewUsersFragment.OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link NewUsersFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class NewUsersFragment extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private static final String TAG = "NewUsersFragment";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;
    private ProgressBar progressBar;
    private CardStackView cardStackView;
    NewUserCardAdapter adapter;
    private OnFragmentInteractionListener mListener;
    FrameLayout mRelativeLayout;

    List<User> users = new ArrayList<>();


    public NewUsersFragment() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment NewUsersFragment.
     */
    // TODO: Rename and change types and number of parameters
    public static NewUsersFragment newInstance(String param1, String param2) {
        NewUsersFragment fragment = new NewUsersFragment();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_new_users, container, false);
//        ViewPager viewPager = (ViewPager) view.findViewById(R.id.viewpager);
//        viewPager.setAdapter();
        mRelativeLayout = view.findViewById(R.id.rl);
        setup(view);
        reload();
        return view;
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
        if (context instanceof OnFragmentInteractionListener) {
            mListener = (OnFragmentInteractionListener) context;
        } else {
            throw new RuntimeException(context.toString()
                    + " must implement OnFragmentInteractionListener");
        }
    }

    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
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

    private void setup(View view) {
        progressBar = (ProgressBar) view.findViewById(R.id.activity_main_progress_bar);

        cardStackView = (CardStackView) view.findViewById(R.id.activity_main_card_stack_view);

        cardStackView.setCardEventListener(new CardStackView.CardEventListener() {
            @Override
            public void onCardDragging(float percentX, float percentY) {
                Log.d("CardStackView", "onCardDragging");
            }

            @Override
            public void onCardSwiped(SwipeDirection direction) {
                Log.d("CardStackView", "onCardSwiped: " + direction.toString());
                Log.d("CardStackView", "topIndex: " + cardStackView.getTopIndex());
                if (cardStackView.getTopIndex() == adapter.getCount() - 5) {
                    Log.d("CardStackView", "Paginate: " + cardStackView.getTopIndex());
                    paginate();
                }
            }

            @Override
            public void onCardReversed() {
                Log.d("CardStackView", "onCardReversed");
            }

            @Override
            public void onCardMovedToOrigin() {
                Log.d("CardStackView", "onCardMovedToOrigin");
            }

            @Override
            public void onCardClicked(int index) {
                Log.d("CardStackView", "onCardClicked: " + index);
            }
        });
    }

    private void reload() {
        cardStackView.setVisibility(View.GONE);
        progressBar.setVisibility(View.VISIBLE);
        Api api = new Api(getActivity());
        api.fetchNewUsers(User.getCurrentUserId(), new Callback<List<User>>() {
            @Override
            public void onResponse(Call<List<User>> call, Response<List<User>> response) {
                users.clear();
                Log.v(TAG, "resp "+response.message());
                try {
                    if (response.body()!=null)
                        users = response.body();

                    if(users != null){
                        Log.v(TAG, "usersSize "+users.size());

                        setTabBadgeText(2, users.size());
                        adapter = createNewUserCardAdapter(users);
                        cardStackView.setAdapter(adapter);
                        cardStackView.setVisibility(View.VISIBLE);
                        adapter.notifyDataSetChanged();

                    }else {                Log.v(TAG, "users null ");
                    }
                    progressBar.setVisibility(View.GONE);
                    setTabBadgeText(users.size());

                }catch (NullPointerException e){
                    e.printStackTrace();
                }

            }

            @Override
            public void onFailure(Call<List<User>> call, Throwable t) {
                Log.e(TAG, " fetchNewUsers failed");
                progressBar.setVisibility(View.GONE);
                try {
                    Snackbar.make(getView().findViewById(R.id.rl), R.string.list_empty,
                            Snackbar.LENGTH_SHORT)
                            .show();
                }catch (NullPointerException e){
                    e.printStackTrace();
                }

                setTabBadgeText(users.size());


            }
        });
        /*
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                adapter = createNewUserCardAdapter();
                cardStackView.setAdapter(adapter);
                cardStackView.setVisibility(View.VISIBLE);
                progressBar.setVisibility(View.GONE);
            }
        }, 1000);*/
    }

    private void setTabBadgeText(int i, int size) {
        if(users.size()>0){
            ((MainActivity)getActivity()).setTabBadgeText(2, users.size()+"");
        }else{
            Snackbar.make(getView().findViewById(R.id.rl), R.string.list_empty,
                    Snackbar.LENGTH_SHORT)
                    .show();
        }
    }

    private LinkedList<User> extractRemainingCard() {
        LinkedList<User> users = new LinkedList<>();
        for (int i = cardStackView.getTopIndex(); i < adapter.getCount(); i++) {
            users.add(adapter.getItem(i));
        }
        return users;
    }
/*
    private void addFirst() {
        LinkedList<User> users = extractRemainingCard();
        spots.addFirst(createNewUser());
        adapter.clear();
        adapter.addAll(spots);
        adapter.notifyDataSetChanged();
    }

    private void addLast() {
        LinkedList<User> card = extractRemainingCard();
        spots.addLast(createNewUser());
        adapter.clear();
        adapter.addAll(spots);
        adapter.notifyDataSetChanged();
    }*/

    private void removeFirst() {
        LinkedList<User> users  = extractRemainingCard();
        setTabBadgeText(users.size());
        if (users.isEmpty()) {
            return;
        }

        users.removeFirst();
        adapter.clear();
        adapter.addAll(users);
        adapter.notifyDataSetChanged();

    }

    private void setTabBadgeText(int value) {
        setTabBadgeText(2,value);
    }

    private void removeLast() {
        LinkedList<User> users = extractRemainingCard();
        if (users.isEmpty()) {
            return;
        }

        users.removeLast();
        adapter.clear();
        adapter.addAll(users);
        adapter.notifyDataSetChanged();
        setTabBadgeText(users.size());

    }

    private void paginate() {
        cardStackView.setPaginationReserved();
       // adapter.addAll(users);
       // adapter.notifyDataSetChanged();
        setTabBadgeText(users.size());

    }

    public void swipeLeft() {
        List<User> users = extractRemainingCard();
        if (users.isEmpty()) {
            return;
        }

        View target = cardStackView.getTopView();

        ValueAnimator rotation = ObjectAnimator.ofPropertyValuesHolder(
                target, PropertyValuesHolder.ofFloat("rotation", -10f));
        rotation.setDuration(200);
        ValueAnimator translateX = ObjectAnimator.ofPropertyValuesHolder(
                target, PropertyValuesHolder.ofFloat("translationX", 0f, -2000f));
        ValueAnimator translateY = ObjectAnimator.ofPropertyValuesHolder(
                target, PropertyValuesHolder.ofFloat("translationY", 0f, 500f));
        translateX.setStartDelay(100);
        translateY.setStartDelay(100);
        translateX.setDuration(500);
        translateY.setDuration(500);
        AnimatorSet set = new AnimatorSet();
        set.playTogether(rotation, translateX, translateY);

        cardStackView.swipe(SwipeDirection.Left, set);
        removeFirst();
    }

    public void swipeRight() {
        List<User> user = extractRemainingCard();
        if (user.isEmpty()) {
            return;
        }

        View target = cardStackView.getTopView();

        ValueAnimator rotation = ObjectAnimator.ofPropertyValuesHolder(
                target, PropertyValuesHolder.ofFloat("rotation", 10f));
        rotation.setDuration(200);
        ValueAnimator translateX = ObjectAnimator.ofPropertyValuesHolder(
                target, PropertyValuesHolder.ofFloat("translationX", 0f, 2000f));
        ValueAnimator translateY = ObjectAnimator.ofPropertyValuesHolder(
                target, PropertyValuesHolder.ofFloat("translationY", 0f, 500f));
        translateX.setStartDelay(100);
        translateY.setStartDelay(100);
        translateX.setDuration(500);
        translateY.setDuration(500);
        AnimatorSet set = new AnimatorSet();
        set.playTogether(rotation, translateX, translateY);

        cardStackView.swipe(SwipeDirection.Right, set);
        Api api = new Api(getActivity());
        api.likeUserToGroup(User.getCurrentUserId(), user.get(0).getId(), new Callback<JSONObject>() {
            @Override
            public void onResponse(Call<JSONObject> call, Response<JSONObject> response) {
                if (response.body()==null) return;
                    JSONObject r = response.body();
                    if(r.optString("status","failed").equals("success")){
                        removeFirst();
                       // adapter.notifyDataSetChanged();
                    }
            }

            @Override
            public void onFailure(Call<JSONObject> call, Throwable t) {
                Log.e(TAG, call.toString());
                reload();
            }
        });
    }

    private void reverse() {
        cardStackView.reverse();
    }


    private NewUserCardAdapter createNewUserCardAdapter(List<User> userList) {
        final NewUserCardAdapter adapter = new NewUserCardAdapter(getContext(), new ClickCard() {
            @Override
            public void Click(boolean b) {
                if (b)
                    swipeRight();
                else
                    swipeLeft();
            }
        }, createPopUp());
        adapter.addAll(userList);
        return adapter;
    }

    private ClickShowPopup createPopUp() {
       return new ClickShowPopup<User>() {
           public PopupWindow mPopupWindow;

           @Override
           public void Show(User user) {
               LayoutInflater inflater = (LayoutInflater) getContext().getSystemService(LAYOUT_INFLATER_SERVICE);

               // Inflate the custom layout/view
               View customView = inflater.inflate(R.layout.profile_popup, null);

               ImageView imageView = customView.findViewById(R.id.imageView2);
                Glide.with(getContext()).load(user.getPhoto()).into(imageView);
                TextView name = customView.findViewById(R.id.tv_name);
               name.setText(getString(R.string.name_n_age, user.getFullname(), user.getAge()));
                TextView about = customView.findViewById(R.id.tv_desc);
               about.setText(user.getAbout());
                TextView city = customView.findViewById(R.id.tv_city);
               city.setText(user.getAddress());
                TextView pref = customView.findViewById(R.id.tv_pref);
                pref.setText(user.getGenderPrefAsText());
                TextView religion = customView.findViewById(R.id.tv_religon);
                religion.setText(user.getReligonAsText());


               LinearLayout menubar = customView.findViewById(R.id.menubar);
               menubar.setVisibility(View.GONE);
               mPopupWindow = new PopupWindow(
                       customView,
                       ViewGroup.LayoutParams.WRAP_CONTENT,
                       ViewGroup.LayoutParams.WRAP_CONTENT
               );
               if (Build.VERSION.SDK_INT >= 21) {
                   mPopupWindow.setElevation(5.0f);
               }

               // Get a reference for the custom view close button
               ImageView closeButton = customView.findViewById(R.id.back);

               // Set a click listener for the popup window close button
               closeButton.setOnClickListener(new View.OnClickListener() {
                   @Override
                   public void onClick(View view) {
                       // Dismiss the popup window
                       mPopupWindow.dismiss();
                   }
               });

               mPopupWindow.showAtLocation(mRelativeLayout, Gravity.CENTER, 0, 0);
           }
       };
    }


}

package com.shindygo.shindy;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.content.ContextCompat;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.DividerItemDecoration;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.facebook.AccessToken;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.google.gson.JsonObject;
import com.shindygo.shindy.interfaces.ClickCard;
import com.shindygo.shindy.interfaces.ClickUser;
import com.shindygo.shindy.adapter.UsersAdapter;
import com.shindygo.shindy.model.Filter;
import com.shindygo.shindy.model.User;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.Unbinder;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.content.Context.LAYOUT_INFLATER_SERVICE;
import static com.shindygo.shindy.SearchFilterActivity.FILTER;

/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link UsersFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class UsersFragment extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private static final String TAG = UsersFragment.class.getSimpleName();
    private static final String INVITE_URL = "http://shindygo.com/";
    private static final String FB_RQ_FRIENDS = "user_friends";
    private static final int FACEBOOK = 2;


    @BindView(R.id.search_user_img)
    ImageView searchUserImg;
    @BindView(R.id.search_user_spinner)
    Spinner searchUserSpinner;
    @BindView(R.id.search_user_filters_txt)
    TextView searchUserFiltersTxt;
    @BindView(R.id.search_view)
    LinearLayout searchView;
    @BindView(R.id.recycler_view)
    RecyclerView recyclerView;
    Unbinder unbinder;
    List<User> users= new ArrayList<>();
    @BindView(R.id.ll_main_users)
    LinearLayout llMainUsers;
    @BindView(R.id.et_search)
    EditText etSearch;
    @BindView(R.id.clear)
    ImageView clear;
    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;
    private Filter pFilter;
    private OnFragmentInteractionListener mListener;
    private UsersAdapter adapter;
    LinearLayoutManager layoutManager;
    private PopupWindow mPopupWindow, messPopup;
    private CallbackManager callbackManager;

    public UsersFragment() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment UsersFragment.
     */
    // TODO: Rename and change types and number of parameters
    public static UsersFragment newInstance(String param1, String param2) {
        UsersFragment fragment = new UsersFragment();
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
        View view = inflater.inflate(R.layout.fragment_users, container, false);
        final RecyclerView recyclerView = (RecyclerView) view.findViewById(R.id.recycler_view);
        layoutManager = new LinearLayoutManager(getContext());

        RecyclerView.ItemAnimator animator = recyclerView.getItemAnimator();
        if (animator instanceof DefaultItemAnimator) {
            ((DefaultItemAnimator) animator).setSupportsChangeAnimations(false);
        }
        unbinder = ButterKnife.bind(this, view);
        searchUserFiltersTxt.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getContext(), SearchFilterActivity.class);
                if (pFilter!=null)
                    intent.putExtra(FILTER,pFilter);
                startActivityForResult(intent,96);
            }
        });
        adapter = new UsersAdapter(users, new ClickUser() {
            @Override
            public void Click(User user) {
            }
        }, new ClickCard() {
            @Override
            public void Click(boolean b) {
//
            }
        });
        searchUserImg.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(final View view) {
                final boolean hidden = searchView.getVisibility() != View.VISIBLE;
/*                searchView.animate()
                        .translationY(searchView.getHeight())
                        //.alpha(0.0f)
                        .setDuration(R.integer.ANIM_TRANS_TIME)
                        .setListener(new AnimatorListenerAdapter() {
                            @Override
                            public void onAnimationEnd(Animator animation) {
                                super.onAnimationEnd(animation);
                                searchView.setVisibility(hidden? View.VISIBLE : View.GONE);
                            }
                        });*/
                /*TranslateAnimation animate = new TranslateAnimation(0,0,0,
                        !hidden? searchView.getHeight(): -searchView.getHeight());
                animate.setDuration(R.integer.ANIM_TRANS_TIME);
                animate.setFillAfter(true);
                searchView.startAnimation(animate);*/

                /*searchView.setVisibility(
                        !hidden? View.GONE: View.VISIBLE)*/;
                if(hidden){
                    Animation slideDown = AnimationUtils.loadAnimation(getActivity(), R.anim.slide_down);
                    searchView.setVisibility(View.VISIBLE);
                    searchView.startAnimation(slideDown);
                    etSearch.requestFocus(etSearch.getText().toString().length());
                    InputMethodManager imm = (InputMethodManager) getActivity().getSystemService(Context.INPUT_METHOD_SERVICE);
                    imm.toggleSoftInput(InputMethodManager.SHOW_FORCED,0);
                }else{
                    Animation slideUp = AnimationUtils.loadAnimation(getActivity(), R.anim.slide_up);
                    searchView.startAnimation(slideUp);
                    slideUp.setAnimationListener(new Animation.AnimationListener() {
                        @Override
                        public void onAnimationStart(Animation animation) {

                        }

                        @Override
                        public void onAnimationEnd(Animation animation) {
                            searchView.setVisibility(View.GONE);
                        }

                        @Override
                        public void onAnimationRepeat(Animation animation) {

                        }
                    });
                    //searchView.setVisibility(View.GONE);
                    InputMethodManager imm = (InputMethodManager)getActivity(). getSystemService(Context.INPUT_METHOD_SERVICE);
                    imm.hideSoftInputFromWindow(view.getWindowToken(),0);
                }

            }
        });
/*        etSearch.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int i, KeyEvent keyEvent) {
                Log.v(TAG, "onEditorAction "+ textView.getText().toString());
                seachF(etSearch.getText().toString());

                return true;
            }
        });*/
        etSearch.addTextChangedListener(new TextWatcher() {
            @Override
            public void afterTextChanged(Editable s) {
                Log.v(TAG, "afterTextChanged "+ etSearch.getText().toString());
                seachF(etSearch.getText().toString());            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
                // TODO Auto-generated method stub
            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                Log.v(TAG, "onTextChanged "+ etSearch.getText().toString());
                seachF(etSearch.getText().toString());
            }
        });
        clear.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                etSearch.setText("");
            }
        });
        //seach("");
       searchUserSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
           @Override
           public void onItemSelected(AdapterView<?> adapterView, View view, int position, long l) {

               switch (position){
                   case FACEBOOK:
                       users.clear();
                       adapter.notifyDataSetChanged();
                       /*AccessToken accessToken = AccessToken.getCurrentAccessToken();
                       Log.v(TAG,"fb accessToken");
                       Log.v(TAG,"size: "+accessToken.getPermissions().size());
                       Log.v(TAG,"size: "+accessToken.getPermissions().iterator().toString());
                       Log.v(TAG,"size: "+accessToken.getPermissions().toArray()[0]);
                       Log.v(TAG,"size: "+accessToken.getPermissions().toArray()[1]);
                       if(hasPermission(FB_RQ_FRIENDS)){

                           GraphRequest request = GraphRequest.newGraphPathRequest(
                                   AccessToken.getCurrentAccessToken(),
                                   "/"+ Profile.getCurrentProfile().getId() +"/friends",
                                   new GraphRequest.Callback() {
                                       @Override
                                       public void onCompleted(GraphResponse response) {
                                           // Insert your code here
                                           Log.v(TAG,"fb friendslist");
                                           Log.v(TAG,response.toString());

                                       }
                                   });

                           request.executeAsync();
                       }
*/
                       break;

                   default:
                       seachF(etSearch.getText().toString());
                       break;
               }
           }

           @Override
           public void onNothingSelected(AdapterView<?> adapterView) {

           }
       });

        //fbInit();
        return view;
    }

    private void fbInit() {
        callbackManager = CallbackManager.Factory.create();
       if(!hasPermission(FB_RQ_FRIENDS)){
           LoginManager mLoginManager = LoginManager.getInstance();
           mLoginManager.logInWithReadPermissions(this, Arrays.asList(FB_RQ_FRIENDS));
           mLoginManager.logInWithPublishPermissions(this,
                   Arrays.asList(new String[]{"publish_actions"}));
           mLoginManager.registerCallback(callbackManager, new FacebookCallback<LoginResult>() {
               @Override
               public void onSuccess(LoginResult loginResult) {
                   //Toast.makeText(getActivity(), "Facebook login success!", Toast.LENGTH_SHORT).show();
                   Log.v(TAG,"Facebook login success" );
               }
               @Override
               public void onCancel() {
                   Toast.makeText(getActivity(), "Facebook login canceled!", Toast.LENGTH_SHORT).show(); }
               @Override
               public void onError(FacebookException exception) {
                   Toast.makeText(getActivity(), "Facebook login error: " + exception.getMessage(), Toast.LENGTH_SHORT).show();
               } });

       }

    }

    private boolean hasPermission(String request){
        return AccessToken.getCurrentAccessToken().getPermissions().contains(request);
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

    @Override
    public void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
//        adapter.onSaveInstanceState(outState);
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        callbackManager.onActivityResult(requestCode, resultCode, data);

        switch (requestCode){
            case 96:
                if (resultCode== Activity.RESULT_OK) {
                    pFilter = data.getParcelableExtra(FILTER);
                    if (!pFilter.isClear()) {
                        searchUserFiltersTxt.setText(getText(R.string.filtersApl));
                        searchUserFiltersTxt.setBackgroundColor(Color.parseColor("#FFA500"));
                    }
                    else
                    {
                        searchUserFiltersTxt.setText("+FILTER");
                        searchUserFiltersTxt.setBackgroundColor(Color.TRANSPARENT);
                    }

                    seachF(etSearch.getText().toString());
                }

                break;

        }

    }
    private  void seachF(String text){

        final Api api = new Api(getContext());
        api.searchUserF(text,pFilter,searchUserSpinner.getSelectedItemPosition(),new Callback<List<User>>() {
            @Override
            public void onResponse(Call<List<User>> call, Response<List<User>> response) {
                users.clear();
                if (response.body()!=null)
                    users = response.body();
                adapter.notifyDataSetChanged();
                Log.i("Search", response.message());
                try {
                    DividerItemDecoration dividerItemDecoration = new DividerItemDecoration(recyclerView.getContext(),
                            layoutManager.getOrientation());
                    recyclerView.addItemDecoration(dividerItemDecoration);
                    adapter = new UsersAdapter(users, new ClickUser() {
                        @Override
                        public void Click(final User user) {
                            LayoutInflater inflater = (LayoutInflater) getContext().getSystemService(LAYOUT_INFLATER_SERVICE);

                            final SharedPreferences sharedPref = getContext().getSharedPreferences("set", Context.MODE_PRIVATE);
                            final String id = sharedPref.getString("fbid", "");

                            // Inflate the custom layout/view
                            View customView = inflater.inflate(R.layout.profile_popup, null);
                            ImageView imageView = customView.findViewById(R.id.imageView2);
                            final ImageView star = customView.findViewById(R.id.iv_star);
                            Glide.with(getContext()).load(user.getPhoto()).into(imageView);
                            TextView name = customView.findViewById(R.id.tv_name);
                            TextView about = customView.findViewById(R.id.tv_desc);
                            about.setText(user.getAbout());
                            TextView city = customView.findViewById(R.id.tv_city);
                            city.setText(user.getAddress());
                            TextView religion = customView.findViewById(R.id.tv_religon);
                            religion.setText(user.getReligion());
                            TextView pref = customView.findViewById(R.id.tv_pref);
                            pref.setText("Preference: " + user.getGenderPref());
                            name.setText(user.getFullname());
                            LinearLayout linearLayout = customView.findViewById(R.id.ll_block);
                            linearLayout.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {

                                    api.blockUser(id, user.getFbid(), new Callback<Object>() {
                                        @Override
                                        public void onResponse(Call<Object> call, Response<Object> response) {
                                            Toast.makeText(getContext(), "User blocked succesfuly!", Toast.LENGTH_SHORT).show();
                                            mPopupWindow.dismiss();
                                        }

                                        @Override
                                        public void onFailure(Call<Object> call, Throwable t) {
                                            Toast.makeText(getContext(), "Error", Toast.LENGTH_SHORT).show();
                                            mPopupWindow.dismiss();
                                        }
                                    });
                                }
                            });

                            LinearLayout ll_message = customView.findViewById(R.id.ll_message);
                            ll_message.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    createMessage();
                                }
                            });
                            LinearLayout favorite = customView.findViewById(R.id.ll_favorite);
                            favorite.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    if (user.getMarkasfavorite().equals("0")) {
                                        star.setColorFilter(ContextCompat.getColor(getContext(), R.color.navigation_notification_yellow));
                                        api.addFavoriteUser(id, user.getFbid(), new Callback<Object>() {
                                            @Override
                                            public void onResponse(Call<Object> call, Response<Object> response) {
                                                Toast.makeText(getContext(), "User favorite!", Toast.LENGTH_SHORT).show();
                                                users.get(users.indexOf(user)).setMarkasfavorite("1");
                                                user.setMarkasfavorite("1");
                                                adapter.notifyDataSetChanged();
                                                //   mPopupWindow.dismiss();
                                            }

                                            @Override
                                            public void onFailure(Call<Object> call, Throwable t) {
                                                Toast.makeText(getContext(), "Error", Toast.LENGTH_SHORT).show();
                                                mPopupWindow.dismiss();
                                            }
                                        });
                                    } else {
                                        star.setColorFilter(null);
                                        api.RemoveFavoriteUser(id, user.getFbid(), new Callback<Object>() {
                                            @Override
                                            public void onResponse(Call<Object> call, Response<Object> response) {
                                                Toast.makeText(getContext(), "User remove from favorite!", Toast.LENGTH_SHORT).show();
                                                users.get(users.indexOf(user)).setMarkasfavorite("0");
                                                user.setMarkasfavorite("0");
                                                adapter.notifyDataSetChanged();
                                                //   mPopupWindow.dismiss();
                                            }

                                            @Override
                                            public void onFailure(Call<Object> call, Throwable t) {
                                                Toast.makeText(getContext(), "Error", Toast.LENGTH_SHORT).show();
                                                mPopupWindow.dismiss();
                                            }
                                        });
                                    }
                                }
                            });
                            if (user.getMarkasfavorite().equals("1")) {
                                star.setColorFilter(ContextCompat.getColor(getContext(), R.color.navigation_notification_yellow));
                            } else
                                star.setColorFilter(null);
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

                            mPopupWindow.showAtLocation(llMainUsers, Gravity.CENTER, 0, 0);
                        }
                    }, new ClickCard() {
                        @Override
                        public void Click(boolean b) {
                            //mPopupWindow.dismiss();
                            createMessage();
                        }
                    });
                    recyclerView.setLayoutManager(layoutManager);
                    recyclerView.setAdapter(adapter);
                }catch (NullPointerException e){
                    e.printStackTrace();
                }

            }

            @Override
            public void onFailure(Call<List<User>> call, Throwable t) {
                users.clear();
                try {
                    adapter.notifyDataSetChanged();
                    Log.i(TAG, "onFailure");
                    t.printStackTrace();
                }catch (NullPointerException e){
                    e.printStackTrace();
                }

            }
        });


    }

    private void selectFacebook(JsonObject object){

        Log.i(TAG, "FB "+object.toString());
        DividerItemDecoration dividerItemDecoration = new DividerItemDecoration(recyclerView.getContext(),
                layoutManager.getOrientation());
        recyclerView.addItemDecoration(dividerItemDecoration);
         recyclerView.setLayoutManager(layoutManager);
        recyclerView.setAdapter(adapter);
    }

    private void createMessage() {
        LayoutInflater inflater = (LayoutInflater) getContext().getSystemService(LAYOUT_INFLATER_SERVICE);

        // Inflate the custom layout/view
        View customView = inflater.inflate(R.layout.message_popup, null);
        final TextView textView = customView.findViewById(R.id.textView2);
        EditText editText = customView.findViewById(R.id.editText);
        editText.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void afterTextChanged(Editable editable) {
                textView.setText(300 - editable.length()+" charecters left");
            }
        });
        messPopup = new PopupWindow(
                customView,
                ViewGroup.LayoutParams.WRAP_CONTENT,
                ViewGroup.LayoutParams.WRAP_CONTENT,
                true
        );
        if (Build.VERSION.SDK_INT >= 21) {
            messPopup.setElevation(5.0f);
        }

        // Get a reference for the custom view close button
        ImageView closeButton = customView.findViewById(R.id.close);
        // Set a click listener for the popup window close button
        closeButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // Dismiss the popup window
                messPopup.dismiss();
            }
        });

        messPopup.showAtLocation(llMainUsers, Gravity.CENTER, 0, 0);
    }


}

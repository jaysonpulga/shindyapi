package com.shindygo.shindy;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.request.RequestListener;
import com.facebook.AccessToken;
import com.facebook.AccessTokenTracker;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.FacebookSdk;
import com.facebook.GraphRequest;
import com.facebook.GraphResponse;
import com.facebook.Profile;
import com.facebook.ProfileTracker;
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.facebook.login.widget.LoginButton;
import com.shindygo.shindy.interfaces.ShindiServer;
import com.shindygo.shindy.model.User;
import com.shindygo.shindy.utils.FontUtils;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.MalformedURLException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.security.Signature;
import java.util.Arrays;
import java.util.List;
import java.util.Set;

import butterknife.BindView;
import butterknife.ButterKnife;
import okhttp3.OkHttpClient;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class LoginActivity extends AppCompatActivity {

    private static final String TAG = LoginActivity.class.getSimpleName();
    private static final List<String> FB_RQ_PERMISSION = Arrays.asList("user_birthday","public_profile",
            "email","user_location","user_friends","user_age_range");


    @BindView(R.id.appTitle)
    TextView appTitle;
    @BindView(R.id.app_text)
    TextView appText;

    @BindView(R.id.fb_verfication_txt)
    TextView fbVerficationTxt;
    LoginButton loginButton;

    private CallbackManager callbackManager;
    private AccessTokenTracker accessTokenTracker;
    private ProfileTracker profileTracker;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        FacebookSdk.sdkInitialize(getApplicationContext());

        setContentView(R.layout.activity_login);
        ButterKnife.bind(this);
        Api.initialized(this        );


        FontUtils.setFont(appTitle, FontUtils.Roboto_Light);
        FontUtils.setFont(appText, FontUtils.Roboto_Light);
    //FontUtils.setFont(fbLoginBtn, FontUtils.Roboto_Medium);
        FontUtils.setFont(fbVerficationTxt, FontUtils.Roboto_Light);

        callbackManager = CallbackManager.Factory.create();

        accessTokenTracker = new AccessTokenTracker() {
            @Override
            protected void onCurrentAccessTokenChanged(AccessToken oldToken, AccessToken newToken) {
                if (newToken!=null)
                newToken.getDeclinedPermissions();

            }
        };

      /*  profileTracker = new ProfileTracker() {
            @Override
            protected void onCurrentProfileChanged(Profile oldProfile, Profile newProfile) {
            //    nextActivity(newProfile);
            }
        };*/
        accessTokenTracker.startTracking();
   /*     profileTracker.startTracking();*/

      loginButton = (LoginButton)findViewById(R.id.login_button);
        loginButton.setReadPermissions(FB_RQ_PERMISSION);
        //loginButton.setPublishPermissions(Arrays.asList("publish_actions"));
        loginButton.registerCallback(callbackManager, callback);






    }



    //Facebook login button
    private FacebookCallback<LoginResult> callback = new FacebookCallback<LoginResult>() {
        @Override
        public void onSuccess(LoginResult loginResult) {

           // LoginManager.getInstance().logInWithReadPermissions(LoginActivity.this, Arrays.asList("user_birthday","email", "user_location"));

           Set<String> per= loginResult.getAccessToken().getDeclinedPermissions();
            Set<String> paer= loginResult.getAccessToken().getPermissions();

            GraphRequest request = GraphRequest.newMeRequest(loginResult.getAccessToken(),
                    new GraphRequest.GraphJSONObjectCallback() {
                         String email ="";
                         String location ="";
                        @Override
                        public void onCompleted(final JSONObject object, GraphResponse response) {
                            Log.v("LoginActivity", response.toString());

                            Log.v("LoginActivity", object.toString());

                                try {
                                    email = object.getString("email");
                                }catch (Exception e)
                                {
                                    email = "noemail@gmail.com";
                                }
                            String birthday = object.optString("birthday",""); // 01/31/1980 format
                            try {
                                location = object.getJSONObject("location").optString("name","");
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                            if(Profile.getCurrentProfile()==null){
                                    profileTracker = new ProfileTracker() {
                                        @Override
                                        protected void onCurrentProfileChanged(Profile oldProfile, Profile newProfile) {
                                            Profile.setCurrentProfile(newProfile);

                                            profileTracker.stopTracking();
                                            User user = new User(newProfile.getId(), newProfile.getName(),email);

                                            String photoUrl = newProfile.getProfilePictureUri(200,200).toString();
                                            user.setPhoto(photoUrl);
                                            user.setAddress(location);
                                            User.setCurrentUser(user);
                                            nextActivity( user);
                                        }
                                    };
                                    profileTracker.startTracking();
                            }else {
                                nextActivity( Profile.getCurrentProfile(),email,birthday);
                             /*   LoginManager.getInstance().logInWithReadPermissions(
                                        LoginActivity.this,
                                        Arrays.asList("user_birthday","email","user_location"));*/
                            }


                        }
                    });
            Bundle parameters = new Bundle();
            parameters.putString("fields", "id,name,email,gender,birthday,location");
            request.setParameters(parameters);
            request.executeAsync();


        }
        @Override
        public void onCancel() {

        }
        @Override
        public void onError(FacebookException e) {      }
    };

    private void nextActivity(Profile profile,String email,String birthday){
        if(profile != null){
/*
            SharedPreferences sharedPref =   getSharedPreferences("set", Context.MODE_PRIVATE);
            SharedPreferences.Editor editor = sharedPref.edit();
            editor.putString("name", profile.getName());
            editor.putString("fbid", profile.getId());
            editor.putString("url", profile.getProfilePictureUri(200,200).toString());
            editor.apply();*/
            Api api = new Api(this);
            User user = new User(profile.getId(), profile.getName(),email);

            String photoUrl = profile.getProfilePictureUri(200,200).toString();
            user.setPhoto(photoUrl);
            User.setCurrentUser(user);
            api.checkUser(user, new Callback<Object>() {

                @Override
                public void onResponse(Call<Object> call, Response<Object> response) {

                    Log.v("login",response.message());
                    //no data
                }

                @Override
                public void onFailure(Call<Object> call, Throwable t) {
                    Log.e(TAG,t.getMessage());
                }
            });
            Intent main = new Intent(LoginActivity.this, MainActivity.class);
/*
            main.putExtra("name", profile.getFirstName());
            main.putExtra("surname", profile.getLastName());
            main.putExtra("imageUrl", profile.getProfilePictureUri(200,200).toString());
*/
           main .setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
           startActivity(main);
           finish();
        }

    }

    private void nextActivity(User user){
        new Api(this).checkUser(user, new Callback<Object>() {

            @Override
            public void onResponse(Call<Object> call, Response<Object> response) {

                Log.v("login",response.message());
                //no data
            }

            @Override
            public void onFailure(Call<Object> call, Throwable t) {
                Log.e(TAG,t.getMessage());
            }
        });
        Intent main = new Intent(LoginActivity.this, MainActivity.class);
        main .setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
        startActivity(main);
        finish();
    }

    public  void printHashKey(Context pContext) {
        try {
            PackageInfo info = getPackageManager().getPackageInfo(getPackageName(), PackageManager.GET_SIGNATURES);
            for (android.content.pm.Signature signature : info.signatures) {
                MessageDigest md = MessageDigest.getInstance("SHA");
                md.update(signature.toByteArray());
                String hashKey = new String(Base64.encode(md.digest(), 0));
                Log.i(TAG, "printHashKey() Hash Key: " + hashKey);
            }
        } catch (NoSuchAlgorithmException e) {
            Log.e(TAG, "printHashKey()", e);
        } catch (Exception e) {
            Log.e(TAG, "printHashKey()", e);
        }
    }

    @Override
    protected void onResume() {
        super.onResume();
        //Facebook login
     //   Profile profile = Profile.getCurrentProfile();
       // nextActivity(profile);
    }

    @Override
    protected void onPause() {

        super.onPause();
    }

    protected void onStop() {
        super.onStop();
        //Facebook login
        accessTokenTracker.stopTracking();
        //profileTracker.stopTracking();
    }

    @Override
    protected void onActivityResult(int requestCode, int responseCode, Intent intent) {
        super.onActivityResult(requestCode, responseCode, intent);
        //Facebook login
        callbackManager.onActivityResult(requestCode, responseCode, intent);

    }

    public void OnClickFaceBookLogin(View view) {
        loginButton.callOnClick();
    }
}

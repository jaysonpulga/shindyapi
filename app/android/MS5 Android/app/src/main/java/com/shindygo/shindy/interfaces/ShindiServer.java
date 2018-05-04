package com.shindygo.shindy.interfaces;

import android.content.Context;
import android.content.SharedPreferences;
import android.support.annotation.Nullable;

import com.shindygo.shindy.model.User;

import org.json.JSONObject;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Response;
import retrofit2.http.Body;
import retrofit2.http.Field;
import retrofit2.http.FieldMap;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.Headers;
import retrofit2.http.POST;
import retrofit2.http.Part;
import retrofit2.http.Path;
import retrofit2.http.Query;

/**
 * Created by Anton Kyrychenko on 015 15.03.18.
 */

public interface ShindiServer {
    @Headers({
            "API-key: shindykey456"
    })
    @GET("userlist/api-key/shindykey456 ")
    Call<List<User>> getUsers();
    @Headers({
            "API-key: shindykey456"
    })
    @GET("userlist/fbid/{id}/api-key/shindykey456 ")
    Call<User> getUsersbyId(@Path("id") String id);

    @Headers({
            "API-key: shindykey456",
            "Authorization: Basic c2hpbmR5QGFkbWluOm9yYW5nZUAxMjM="
    })
    @FormUrlEncoded
    @POST("check_user")
    Call<Object> checkUser(@FieldMap Map<String ,Object> user);

    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("update_user")
    Call<Object> updateUser(@FieldMap Map<String ,Object> user);


    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("blokeduser ")
    Call<Object> blockUser(@FieldMap Map<String ,String> user);

    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("userblockedlist")
    Call<List<User>> getBlockedUsersFilter(@Field("user_fbid") String id,@Field("fullname") String text,

                                     @Nullable @Field("")String  distance,
                                     @Nullable @Field("min_age")String  ageto,
                                     @Nullable @Field("max_age")String  agefrom,
                                     @Nullable @Field("gender_pref")int  genderPref,
                                     @Nullable @Field("gender")String  gender,
                                     @Nullable @Field("religion")int  religion);

    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("userblockedlist")
    Call<List<User>> getBlockedUsers(@Field("user_fbid") String id ,@Field("fullname") String name);



    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("SearchAlluserinshindy")
    Call<List<User>> searchUser(@Field("user_fbid") String fbID,@Field("fullname") String text,@Nullable @Field("filterby")String filter);

    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("SearchAlluserinshindy")
    Call<List<User>> searchUserFilter(@Field("user_fbid") String fbID,@Field("fullname") String text,
                                      @Nullable @Field("filterby")String filter,
                                      @Nullable @Field("")String  distance,
                                      @Nullable @Field("min_age")String  ageto,
                                      @Nullable @Field("max_age")String  agefrom,
                                      @Nullable @Field("gender_pref")int  genderPref,
                                      @Nullable @Field("gender")String  gender,
                                      @Nullable @Field("religion")int  religion);


    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("unblocked")
    Call<Object> unblockUser(@FieldMap Map<String ,String> user);




    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("addfavoriteuser")
    Call<Object> addfavoriteUser(@FieldMap Map<String ,String> user);

    @Headers({"API-key: shindykey456"})
    @FormUrlEncoded
    @POST("unfavoriteuser")
    Call<Object> unfavoriteUser(@FieldMap Map<String ,String> user);


}

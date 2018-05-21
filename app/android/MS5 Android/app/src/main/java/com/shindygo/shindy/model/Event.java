package com.shindygo.shindy.model;


import android.util.Log;

import com.google.android.gms.maps.model.LatLng;
import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;


import org.json.JSONException;
import org.json.JSONObject;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import cn.lightsky.infiniteindicator.Page;
public class Event implements Serializable{

    @SerializedName("user_fbid")
    @Expose
    String userFbId;               //*	7777771234567

    @SerializedName("eventname")
    @Expose
    String eventName;               //*	Grand Meeting 2018

    @SerializedName("fulladdress")
    @Expose
    String address;             // *	Calamba Laguna Phillipines


    @SerializedName("long")
    @Expose
    String longitude;	                //Longitude (return on map api)

    @SerializedName("lat")
    @Expose
    String lat;                         //Latitude (return on map api)


    @SerializedName("zipcode")
    @Expose
    String zipCode;                 //*	zipcode (return on map api)

    @SerializedName("image")
    @Expose
    List<Image> image;	                //url image path


    @SerializedName("description")
    @Expose
    String description;	            //sample event description

    @SerializedName("notes")
    @Expose
    String notes;                   //	sample event notes

    @SerializedName("ticketprice")
    @Expose
    String ticketPrice;             //	$10.00

    @SerializedName("representative")
    @Expose
    String representative;          //	id of co-host/representative


    @SerializedName("createdate")
    @Expose
    String createDate;              //	2018-02-01


    @SerializedName("expirydate")
    @Expose
    String expiryDate;              //	2018-02-01

    @SerializedName("sched_startdate")
    @Expose
     String schedStartDate;         //	2018-01-01

    @SerializedName("start_time")
    @Expose
    String startTime ;             //	10:00 AM

    @SerializedName("sched_enddate")
    @Expose
    String schedEndDate;           //	optional for this field, sample(2018-01-01)


    @SerializedName("end_time")
    @Expose
    String endTime;                //	optional for this field, sample value(13:00 PM)

    @SerializedName("spot_available")
    @Expose
    String spotAvailable ;         //	5

    @SerializedName("max_male")
    @Expose
    String maxMale ;               //	4

    @SerializedName("maxFemale")
    @Expose
       String     maxFemale  ;            //	8


    @SerializedName("website_url")
    @Expose
    String websiteUrl  ;           //	www.sample.com


    @SerializedName("eventid")
    @Expose
    String eventId;               //


    @SerializedName("guest_invite_friend")
    @Expose
    String ableGuestInvite;               //1 and 0


    public String getUserFbId() {
        return userFbId;
    }

    public void setUserFbId(String userFbId) {
        this.userFbId = userFbId;
    }

    public String getEventName() {
        return eventName;
    }

    public void setEventName(String eventName) {
        this.eventName = eventName;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getLongitude() {
        return String.valueOf(this.DISNEY.longitude);
    }

    public void setLongitude(String longitude) {
        this.longitude = longitude;
    }

    public String getLat() {
        return String.valueOf(this.DISNEY.latitude);
    }
    private static final LatLng DISNEY = new LatLng(33.809742,-117.915542);

    public void setLat(String lat) {
        this.lat = lat;
    }

    public String getZipCode() {
        return zipCode;
    }

    public void setZipCode(String zipCode) {
        this.zipCode = zipCode;
    }

    public List<Image> getImage() {
        return image;
    }

    public void setImage(List<Image> image) {
        this.image = image;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getNotes() {
        return notes;
    }

    public void setNotes(String notes) {
        this.notes = notes;
    }

    public String getTicketPrice() {
        return ticketPrice;
    }

    public void setTicketPrice(String ticketPrice) {
        this.ticketPrice = ticketPrice;
    }

    public String getRepresentative() {
        return representative;
    }

    public void setRepresentative(String representative) {
        this.representative = representative;
    }

    public String getExpiryDate() {
        return expiryDate;
    }

    public void setExpiryDate(String expiryDate) {
        this.expiryDate = expiryDate;
    }

    public String getSchedStartDate() {
        return schedStartDate;
    }

    public void setSchedStartDate(String schedStartDate) {
        this.schedStartDate = schedStartDate;
    }

    public String getStartTime() {
        return startTime;
    }

    public void setStartTime(String startTime) {
        this.startTime = startTime;
    }

    public String getSchedEndDate() {
        return schedEndDate;
    }

    public void setSchedEndDate(String schedEndDate) {
        this.schedEndDate = schedEndDate;
    }

    public String getEndTime() {
        return endTime;
    }

    public void setEndTime(String endTime) {
        this.endTime = endTime;
    }

    public String getSpotAvailable() {
        return spotAvailable;
    }

    public void setSpotAvailable(String spotAvailable) {
        this.spotAvailable = spotAvailable;
    }

    public String getMaxMale() {
        return maxMale;
    }

    public void setMaxMale(String maxMale) {
        this.maxMale = maxMale;
    }

    public String getMaxFemale() {
        return maxFemale;
    }

    public void setMaxFemale(String maxFemale) {
        this.maxFemale = maxFemale;
    }

    public String getWebsiteUrl() {
        return websiteUrl;
    }

    public void setWebsiteUrl(String websiteUrl) {
        this.websiteUrl = websiteUrl;
    }

    public String getEventId() {
        return eventId;
    }

    public void setEventId(String eventId) {
        this.eventId = eventId;
    }

    public String getCreateDate() {
        return createDate;
    }

    public void setCreateDate(String createDate) {
        this.createDate = createDate;
    }

    public String getAbleGuestInvite() {
        return ableGuestInvite;
    }

    public void setAbleGuestInvite(String ableGuestInvite) {
        this.ableGuestInvite = ableGuestInvite;
    }



    public Map<String,Object> toMap(){
        Map <String,Object> jsonObject  = new HashMap<>();
        jsonObject.put("user_fbid",userFbId);
        jsonObject.put("eventname",eventName);
        jsonObject.put("fulladdress",address);
        jsonObject.put("long",getLongitude());
        jsonObject.put("lat",getLat());
        jsonObject.put("zipcode",zipCode);
        try {
            jsonObject.put("image[]",Image.toJson(getImage()).toString());
            //Log.v("Event", (String) jsonObject.get("image[]"));
        } catch (JSONException e) {
            e.printStackTrace();
        }
        jsonObject.put("description",description);
        jsonObject.put("notes","");
        jsonObject.put("ticketprice",ticketPrice);
        jsonObject.put("representative",representative);
        jsonObject.put("createdate",createDate);
        jsonObject.put("expirydate",expiryDate);
        jsonObject.put("sched_startdate",schedStartDate);
        jsonObject.put("start_time",startTime);
        jsonObject.put("sched_enddate",schedEndDate);
        jsonObject.put("end_time",endTime);
        //jsonObject.put("spot_available",spotAvailable);
        jsonObject.put("max_male",maxMale);
        jsonObject.put("maxFemale",maxFemale);
        jsonObject.put("website_url",websiteUrl);
        jsonObject.put("eventid",eventId);
        jsonObject.put("guest_invite_friend",ableGuestInvite);

        return  jsonObject;
    }
}

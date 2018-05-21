package com.shindygo.shindy.model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;
import com.shindygo.shindy.interfaces.Comment;

public class Review implements Comment {
    @SerializedName("user_fbid")
    @Expose
    String userFbId;                //  user_fbid	fbid of user

    @SerializedName("eventid")
    @Expose
    String eventId;                                  //   eventid	id of event


    @SerializedName("rate")
    @Expose
    String rate;                                  //   rate	rating of event

    @SerializedName("host_review")
    @Expose
    String hostRate;                                  //   hostRate 	rating of host


    @SerializedName("feedback")
    @Expose
    String comment;                             //     comment	comment/discussion for event


    public Review(String userFbId, String eventId, String rate, String hostRate, String comment) {
        this.userFbId = userFbId;
        this.eventId = eventId;
        this.rate = rate;
        this.hostRate = hostRate;
        this.comment = comment;
    }

    @Override
    public String getUserFbId() {
        return userFbId;
    }

    @Override
    public String getUserName() {
        return "Boyoyong";
    }

    @Override
    public String getPhotoPath() {
        return "https://inducesmile.com/wp-content/uploads/2018/03/inducesmilelogo-1.png";
    }

    @Override
    public String getDateCreated() {
        return "10-20-2018";
    }

    @Override
    public String getDateUpdated() {
        return null;
    }

    @Override
    public boolean hasReply() {
        return false;
    }

    public void setUserFbId(String userFbId) {
        this.userFbId = userFbId;
    }

    public String getEventId() {
        return eventId;
    }

    public void setEventId(String eventId) {
        this.eventId = eventId;
    }

    public String getRate() {
        return rate;
    }

    public void setRate(String rate) {
        this.rate = rate;
    }

    public String getHostRate() {
        return hostRate;
    }

    public void setHostRate(String hostRate) {
        this.hostRate = hostRate;
    }

    @Override
    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }
}

package com.shindygo.shindy.model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;
import com.shindygo.shindy.interfaces.Comment;

public class Discussion implements Comment {

    @SerializedName("user_fbid")
    @Expose
    String userFbId;                //  user_fbid	fbid of user


    @SerializedName("eventid")
    @Expose
    String eventId;                                  //   eventid	id of event


    @SerializedName("comment")
    @Expose
    String comment;                             //     comment	comment/discussion for event


    String dateCreated;
    String dateUpdated;

    @Override
    public String getDateCreated() {
        return "10-2-2011";
    }

    public void setDateCreated(String dateCreated) {
        this.dateCreated = dateCreated;
    }

    @Override
    public String getDateUpdated() {
        return dateUpdated;
    }

    @Override
    public boolean hasReply() {
        return false;
    }

    public void setDateUpdated(String dateUpdated) {
        this.dateUpdated = dateUpdated;
    }

    public Discussion(String userFbId, String eventId, String comment) {
        this.userFbId = userFbId;
        this.eventId = eventId;
        this.comment = comment;
    }

    public String getUserFbId() {
        return userFbId;
    }

    @Override
    public String getUserName() {
        return "username";
    }

    @Override
    public String getPhotoPath() {
        return "https://www.google.com.ph/images/branding/googlelogo/2x/googlelogo_color_120x44dp.png";
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

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }

}

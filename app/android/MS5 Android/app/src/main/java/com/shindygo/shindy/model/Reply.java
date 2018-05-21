package com.shindygo.shindy.model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;
import com.shindygo.shindy.interfaces.Comment;

public class Reply implements Comment{

    @SerializedName("user_fbid")
    @Expose
    String userFbId;                //  user_fbid	fbid of user


    @SerializedName("eventid")
    @Expose
    String eventId;                                  //   eventid	id of event


    @SerializedName("reply_comment")
    @Expose
    String comment;                             //     comment	comment/discussion for event


    @SerializedName("discussion_id")
    @Expose
    String discussionId;                             //     comment	comment/discussion for event

    String dateCreated;
    String dateUpdated;

    @Override
    public String getDateCreated() {
        return dateCreated;
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

    public Reply(String userFbId, String eventId, String comment, String discussionId) {
        this.userFbId = userFbId;
        this.eventId = eventId;
        this.comment = comment;
        this.discussionId = discussionId;
    }

    public String getUserFbId() {
        return userFbId;
    }

    @Override
    public String getUserName() {
        return null;
    }

    @Override
    public String getPhotoPath() {
        return null;
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

    public String getDiscussionId() {
        return discussionId;
    }

    public void setDiscussionId(String discussionId) {
        this.discussionId = discussionId;
    }
}

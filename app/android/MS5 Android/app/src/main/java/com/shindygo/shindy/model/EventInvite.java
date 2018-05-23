package com.shindygo.shindy.model;


import com.google.gson.Gson;
import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class EventInvite extends Event {

    @SerializedName("invitation_id")
    @Expose
    String invitationId;

    @SerializedName("custom_price")
    @Expose
    String customPrice;

    @SerializedName("rating")
    @Expose
    String rating;

    @SerializedName("host_review")
    @Expose
    String hostReview;

    @SerializedName("join_male")
    @Expose
    String joinMale;

    @SerializedName("joinfemale")
    @Expose
    String joinFemale;

    @SerializedName("like_status")
    @Expose
    String likeStatus;


    @SerializedName("block_status")
    @Expose
    String blockStatus;


    @SerializedName("invited_status")
    @Expose
    String invitedStatus;


    @SerializedName("attendingstatus")
    @Expose
    String attendingStatus;

    @SerializedName("private_host_fbid")
    @Expose
    String privateHostFbId;

    @SerializedName("private_host")
    @Expose
    String privateHost;

    @SerializedName("invited_by_id")
    @Expose
    String invitedById;

    @SerializedName("invitedby")
    @Expose
    String invitedby;

    @SerializedName("offer_to_pay")
    @Expose
    String offerToPay;

    @SerializedName("invitecode")
    @Expose
    String inviteCode;



    public EventInvite() {
    }

    public String getInvitationId() {
        return invitationId;
    }

    public void setInvitationId(String invitationId) {
        this.invitationId = invitationId;
    }

    public String getCustomPrice() {
        return customPrice;
    }

    public void setCustomPrice(String customPrice) {
        this.customPrice = customPrice;
    }

    public String getRating() {
        return rating;
    }

    public void setRating(String rating) {
        this.rating = rating;
    }

    public String getHostReview() {
        return hostReview;
    }

    public void setHostReview(String hostReview) {
        this.hostReview = hostReview;
    }

    public String getJoinMale() {
        return joinMale;
    }

    public void setJoinMale(String joinMale) {
        this.joinMale = joinMale;
    }

    public String getJoinFemale() {
        return joinFemale;
    }

    public void setJoinFemale(String joinFemale) {
        this.joinFemale = joinFemale;
    }

    public String getLikeStatus() {
        return likeStatus;
    }

    public void setLikeStatus(String likeStatus) {
        this.likeStatus = likeStatus;
    }

    public String getBlockStatus() {
        return blockStatus;
    }

    public void setBlockStatus(String blockStatus) {
        this.blockStatus = blockStatus;
    }

    public String getInvitedStatus() {
        return invitedStatus;
    }

    public void setInvitedStatus(String invitedStatus) {
        this.invitedStatus = invitedStatus;
    }

    public String getAttendingStatus() {
        return attendingStatus;
    }

    public void setAttendingStatus(String attendingStatus) {
        this.attendingStatus = attendingStatus;
    }

    public String getPrivateHostFbId() {
        return privateHostFbId;
    }

    public void setPrivateHostFbId(String privateHostFbId) {
        this.privateHostFbId = privateHostFbId;
    }

    public String getPrivateHost() {
        return privateHost;
    }

    public void setPrivateHost(String privateHost) {
        this.privateHost = privateHost;
    }

    public String getInvitedById() {
        return invitedById;
    }

    public void setInvitedById(String invitedById) {
        this.invitedById = invitedById;
    }

    public String getInvitedby() {
        return invitedby;
    }

    public void setInvitedby(String invitedby) {
        this.invitedby = invitedby;
    }

    public String getOfferToPay() {
        return offerToPay;
    }

    public void setOfferToPay(String offerToPay) {
        this.offerToPay = offerToPay;
    }

    public String getInviteCode() {
        return inviteCode;
    }

    public void setInviteCode(String inviteCode) {
        this.inviteCode = inviteCode;
    }

    public String toJSONObject() {
        return new Gson().toJson(this, EventInvite.class);
    }

    public String toJSON() {
        return new Gson().toJson(this, EventInvite.class);
    }
}

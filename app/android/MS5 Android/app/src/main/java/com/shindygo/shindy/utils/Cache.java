package com.shindygo.shindy.utils;

import android.util.Log;


import com.shindygo.shindy.model.EventInvite;
import com.shindygo.shindy.model.User;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;

public class Cache {
    private static HashMap <String, EventInvite> myAttendingEventsList = new HashMap<String, EventInvite>();

    private static HashMap <String, EventInvite> myInvitedEventsList = new HashMap<String, EventInvite>();

    private static HashMap <String, User> usersList;

    public static HashMap<String, EventInvite> getMyAttendingEventsList() {
        return myAttendingEventsList;
    }

    public static void setMyAttendingEventsList(HashMap<String, EventInvite> myAttendingEventsList) {
        Cache.myAttendingEventsList = myAttendingEventsList;
    }

    public static HashMap<String, EventInvite> getMyInvitedEventsList() {
        return myInvitedEventsList;
    }

    public static void setMyInvitedEventsList(HashMap<String, EventInvite> myInvitedEventsList) {
        Cache.myInvitedEventsList = myInvitedEventsList;
    }

    public static HashMap<String, User> getUsersList() {
        return usersList;
    }

    public static void setUsersList(HashMap<String, User> usersList) {
        Cache.usersList = usersList;
    }

    public static void setMyAttendingEventsList(List<EventInvite> eventsList) {
        if(eventsList==null)return;
        for (int i = 0; i < eventsList.size() ; i++) {
            try {
                EventInvite event = eventsList.get(i);
                myAttendingEventsList.put(event.getEventId(),event);
            }catch (NullPointerException e){
                Log.d("Cache", "null events");

            }
        }


    }
    public static void setMyInvitedEventsList(List<EventInvite> eventsList) {
        if(eventsList==null)return;
        for (int i = 0; i < eventsList.size() ; i++) {
            try {
                EventInvite event = eventsList.get(i);
                myInvitedEventsList.put(event.getEventId(),event);
            }catch (NullPointerException e){
                Log.d("Cache vitedEventsList ", "null events");

            }
        }

    }

    public static List<EventInvite> getEventsAsList(HashMap<String, EventInvite> map){
        List<EventInvite> list = new ArrayList<>();
        EventInvite[] n = map.values().toArray(new EventInvite[map.values().size()]);
        list = Arrays.asList(n);
        return list;
    }

}

package com.shindygo.shindy.model;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Base64;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.Collection;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import cn.lightsky.infiniteindicator.Page;

public class Image {
    @SerializedName("id")
    @Expose
    String id;

    @SerializedName("image_path")
    @Expose
    String path;

    @SerializedName("name")
    @Expose
    String name;

    @SerializedName("data")
    @Expose
    String data;


    public Image(String id, String path) {
        this.id = id;
        this.path = path;
    }
    public Image(String data) {
        this.data = data;
    }


    public Map<String,Object> toMap(){


        Map <String,Object> jsonObject  = new HashMap<>();
        jsonObject.put("id",id);
        jsonObject.put("image_path",path);
        jsonObject.put("name",name);
        jsonObject.put("data",data);

        return  jsonObject;
    }
    public JSONObject toJson() throws JSONException {
        JSONObject jsonObject = new JSONObject();
        jsonObject.put("image_path",path);

/*        jsonObject.put("id",id);
        jsonObject.put("image_path",path);
        jsonObject.put("name",name);
        jsonObject.put("data",data);*/

        return jsonObject;
    }
    public static JSONArray toJson(List<Image> imageList) throws JSONException {
        JSONArray jsonArray = new JSONArray();
        for (int i = 0; i < imageList.size() ; i++) {
            jsonArray.put(imageList.get(i).getData());

        }
        return jsonArray;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getPath() {
        return path;
    }

    public void setPath(String path) {
        this.path = path;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getData() {
        return data;
    }

    public void setData(String data) {
        this.data = data;
    }

    public static List<Image> from(List<com.esafirm.imagepicker.model.Image> images) {
        List<Image> imageList = new ArrayList<>();
        if(images!=null){
            for (int i = 0; i < images.size(); i++) {
                imageList.add(from(images.get(i)));
            }

        }
        return imageList;
    }

    public static Image from(com.esafirm.imagepicker.model.Image image) {
            return new Image(fromPathToData(image.getPath()));
    }

    public static ArrayList<Page> fromImagePickerToPage(List<com.esafirm.imagepicker.model.Image> images) {
        ArrayList<Page> pages = new ArrayList<>();
        if(images==null)return pages;
        for (int i = 0; i < images.size(); i++) {
            try {
                com.esafirm.imagepicker.model.Image image = images.get(i);
                pages.add(new Page(image.getName(), image.getPath()));
            }catch (Exception e){
                e.printStackTrace();
            }
        }
        return pages;
    }

    public static List<Image> from(ArrayList<Page> pageViews) {
        List<Image> imageList = new ArrayList<>();

        if(pageViews!=null){
            for (int i = 0; i < pageViews.size(); i++) {
                imageList.add(from(pageViews.get(i)));
            }
        }
        return imageList;

    }

    private static Image from(Page page) {
        return new Image(fromPathToData((String) page.res));
    }

    private static String fromPathToData(String imagePath){
        Bitmap bm = BitmapFactory.decodeFile(imagePath);
        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        bm.compress(Bitmap.CompressFormat.JPEG, 100, baos); //bm is the bitmap object
        byte[] b = baos.toByteArray();
        return Base64.encodeToString(b, Base64.DEFAULT);
    }

    public static ArrayList <Page> toPage(Event event) {
        ArrayList<Page> pages = new ArrayList<>();
        List<Image> list = event.getImage();
        if(list!=null){
            for (int i = 0; i < list.size(); i++) {
                pages.add(toPage(list.get(i).getData()));
            }
        }
        return pages;
    }

    private static Page toPage(String data) {
        return  new Page(data);

    }
}

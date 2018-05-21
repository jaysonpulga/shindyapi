package com.shindygo.shindy.utils;


import android.content.Context;
import android.widget.ImageView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.shindygo.shindy.R;

import cn.lightsky.infiniteindicator.ImageLoader;

/**
 * Created by lightsky on 16/1/31.
 */
public class GlideLoader implements ImageLoader {

    public void initLoader(Context context) {

    }

    @Override
    public void load(Context context, ImageView targetView, Object res) {

        if (res instanceof String){
            Glide.with(context)
                    .load((String) res)
      //              .apply(RequestOptions.centerCropTransform().placeholder(R.drawable.login_backgroud))
        //            .asB
                    .into(targetView);
        }
    }
}
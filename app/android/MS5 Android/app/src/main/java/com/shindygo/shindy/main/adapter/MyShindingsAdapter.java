package com.shindygo.shindy.main.adapter;

/**
 * Created by User on 16.03.2018.
 */

import android.content.Context;
import android.content.SharedPreferences;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.shindygo.shindy.Api;
import com.shindygo.shindy.R;
import com.shindygo.shindy.interfaces.ClickUser;
import com.shindygo.shindy.model.User;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Sergey on 24.10.2017.
 */

public class MyShindingsAdapter extends RecyclerView.Adapter<MyShindingsAdapter.MyShindingsHolder> {
    Context context;
    List<User> list = new ArrayList<>();
    String id;
    int size;
    ClickUser clickUser;
        public MyShindingsAdapter(int size) {
       this.size = size;
    }
    @Override
    public MyShindingsAdapter.MyShindingsHolder onCreateViewHolder(ViewGroup parent, int viewType) {

        context=parent.getContext();
        final SharedPreferences sharedPref = context.getSharedPreferences("set", Context.MODE_PRIVATE);
        id = sharedPref.getString("fbid", "");
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_my_shindings,null);

        return new MyShindingsAdapter.MyShindingsHolder(view);
    }

    @Override
    public void onBindViewHolder(final MyShindingsHolder holder, final int position) {
        holder.bindModel();
    }

    @Override
    public int getItemCount() {
        return size;
    }

    public class MyShindingsHolder extends RecyclerView.ViewHolder{
//        LinearLayout unblock;
//        ImageView avatar;
//        TextView name;
//        Api api =  new Api(context);

        public MyShindingsHolder(View v) {
            super(v);
//            unblock = v.findViewById(R.id.unblock);
//            avatar = v.findViewById(R.id.iv_avatar);
//            name = v.findViewById(R.id.tv_name_age);

        }
        public void bindModel(){
//            Glide.with(context).load(user.getPhoto()).into(avatar);
//            name.setText(user.getFullname());
//            unblock.setOnClickListener(new View.OnClickListener() {
//                @Override
//                public void onClick(View view) {
//                    clickUser.Click(user);
//                }
//            });
        }
    }

}

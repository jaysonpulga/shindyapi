package com.shindygo.shindy.main.adapter;

/**
 * Created by User on 16.03.2018.
 */

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Build;
import android.support.v4.content.ContextCompat;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.shindygo.shindy.Api;
import com.shindygo.shindy.R;
import com.shindygo.shindy.interfaces.ClickCard;
import com.shindygo.shindy.interfaces.ClickUser;
import com.shindygo.shindy.model.User;

import org.w3c.dom.Text;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.content.Context.LAYOUT_INFLATER_SERVICE;

/**
 * Created by Sergey on 24.10.2017.
 */

public class UsersAdapter extends RecyclerView.Adapter<UsersAdapter.UsersHolder> {
    Context context;
    List<User> users = new ArrayList<>();
    ClickUser clickUser;
    ClickCard clickCard;
    String id;
        public UsersAdapter(List<User> friendList,ClickUser clickUser,ClickCard clickCard) {
        this.users = friendList;
        this.clickUser = clickUser;
        this.clickCard = clickCard;
    }
    @Override
    public UsersAdapter.UsersHolder onCreateViewHolder(ViewGroup parent, int viewType) {

        context=parent.getContext();

        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_user,null);
        final SharedPreferences sharedPref = context.getSharedPreferences("set", Context.MODE_PRIVATE);
        id = sharedPref.getString("fbid", "");
        return new UsersAdapter.UsersHolder(view);
    }

    @Override
    public void onBindViewHolder(final UsersHolder holder, final int position) {
        holder.bindModel(users.get(position),clickUser,clickCard);


    }

    @Override
    public int getItemCount() {
        return users.size();
    }

    public class UsersHolder extends RecyclerView.ViewHolder{
        TextView name;
        ImageView avatar,arrow;
        LinearLayout linearLayout,bar,profile,favorite,message;
        RecyclerView recyclerView;
        Api api = new Api(context);
        ImageView star,favoriteStar;
        TextView textView;
        public UsersHolder(View v) {
            super(v);
            arrow = v.findViewById(R.id.iv_arrow);
            textView = v.findViewById(R.id.tv_Bam);
            name = v.findViewById(R.id.tv_name_age);
            avatar = v.findViewById(R.id.iv_avatar);
            linearLayout = v.findViewById(R.id.ll_main);
            bar = v.findViewById(R.id.main);
            profile = v.findViewById(R.id.ll_profile);
            recyclerView = v.findViewById(R.id.rv_event_user);
            favorite = v.findViewById(R.id.ll_favorite);
            star = v.findViewById(R.id.iv_star);
            favoriteStar = v.findViewById(R.id.star_favorite);
            message = v.findViewById(R.id.ll_message);
        }
        public void bindModel(final User user, final ClickUser clickUser, final ClickCard clickCard){
            name.setText(user.getFullname() + ", " + user.getAge());
            Glide.with(context).load(user.getPhoto()).into(avatar);
            linearLayout.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    bar.setVisibility(bar.getVisibility()==View.VISIBLE?View.GONE:View.VISIBLE);
                }
            });
            arrow.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    textView.setVisibility(View.VISIBLE);

                    android.os.Handler handler = new android.os.Handler();
                    handler.postDelayed(new Runnable() {
                        @Override
                        public void run() {
                            textView.setVisibility(View.GONE);

                        }
                    }, 2000);

                }
            });
            message.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    clickCard.Click(true);
                }
            });
            profile.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    clickUser.Click(user);
                }
            });
            favorite.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    if(user.getMarkasfavorite().equals("0")) {
                        api.addFavoriteUser(id, user.getFbid(), new Callback<Object>() {
                            @Override
                            public void onResponse(Call<Object> call, Response<Object> response) {
                                Toast.makeText(context, "User favorite!", Toast.LENGTH_SHORT).show();
                                star.setColorFilter(ContextCompat.getColor(context, R.color.navigation_notification_yellow));
                                favoriteStar.setColorFilter(ContextCompat.getColor(context, R.color.navigation_notification_yellow));
                                user.setMarkasfavorite("1");
                            }

                            @Override
                            public void onFailure(Call<Object> call, Throwable t) {
                                Toast.makeText(context, "Error", Toast.LENGTH_SHORT).show();
                            }
                        });
                    }
                    else
                    {
                        star.setColorFilter(null);
                        favoriteStar.setColorFilter(null);
                        api.RemoveFavoriteUser(id, user.getFbid(), new Callback<Object>() {
                            @Override
                            public void onResponse(Call<Object> call, Response<Object> response) {
                                Toast.makeText(context, "User remove from favorite!", Toast.LENGTH_SHORT).show();
                                user.setMarkasfavorite("0");
                            }

                            @Override
                            public void onFailure(Call<Object> call, Throwable t) {
                                Toast.makeText(context, "Error", Toast.LENGTH_SHORT).show();

                            }
                        });
                    }
                }
            });
            recyclerView.setLayoutManager(new LinearLayoutManager(context,0,false));
            recyclerView.setAdapter(new EventUserAdapter(new ClickCard() {
                @Override
                public void Click(boolean b) {
                    arrow.setVisibility(View.VISIBLE);
                }
            }));
            if(user.getMarkasfavorite().equals("1"))
            {
                star.setColorFilter(ContextCompat.getColor(context, R.color.navigation_notification_yellow));
                favoriteStar.setColorFilter(ContextCompat.getColor(context, R.color.navigation_notification_yellow));
            }
            else {
                star.setColorFilter(null);
                favoriteStar.setColorFilter(null);
            }
        }
    }

}

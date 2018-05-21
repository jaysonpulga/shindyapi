package com.shindygo.shindy.adapter;

/**
 * Created by User on 16.03.2018.
 */

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.shindygo.shindy.Api;
import com.shindygo.shindy.R;
import com.shindygo.shindy.interfaces.Click;
import com.shindygo.shindy.model.Event;
import com.shindygo.shindy.model.EventInvite;
import com.shindygo.shindy.utils.TextUtils;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Sergey on 24.10.2017.
 */

public class MyShindingsAdapter extends RecyclerView.Adapter<MyShindingsAdapter.MyShindingsHolder> {
    private static final String TAG = MyShindingsAdapter.class.getSimpleName();
    Context context;
    List<EventInvite> list = new ArrayList<>();
    String userFbId;
    int size;
    Click<Event> click;

    public MyShindingsAdapter(List<EventInvite> list, Context context, Click<Event> click) {
        this.list = list;
        this.context = context;
        this.click = click;
        this.size = list.size();
    }

    @Override
    public MyShindingsAdapter.MyShindingsHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        return new MyShindingsAdapter.MyShindingsHolder(LayoutInflater.from(context).inflate(R.layout.item_my_shindings,null));
    }

    @Override
    public void onBindViewHolder(final MyShindingsHolder holder, final int position) {
        holder.bindModel(list.get(position), click);
    }

    @Override
    public int getItemCount() {
        return list.size();
    }

    public class MyShindingsHolder extends RecyclerView.ViewHolder{
       ImageView avatar;
       TextView tvEventName;
       TextView tvEventExpiry;
       TextView tvEventHost;
       TextView tvInviter;
        TextView tvEventPrice;
        TextView tvEventSched;
        TextView tvMaleStocks;
        TextView tvFemaleStocks;
        TextView tvSoldOut;
        LinearLayout layBar;
        LinearLayout layInvited;
        LinearLayout layInvite;
        LinearLayout layDetails;
        RelativeLayout rlContent;

        Api api =  new Api(context);

        public MyShindingsHolder(View v) {
            super(v);
            avatar = v.findViewById(R.id.rivImage);
            tvEventName = v.findViewById(R.id.tv_eventName);
            tvEventExpiry = v.findViewById(R.id.tvEventExpiry);
            tvEventHost = v.findViewById(R.id.tvEventHost);
            tvInviter = v.findViewById(R.id.tvInviter);
            tvEventPrice = v.findViewById(R.id.tvEventPrice);
            tvEventSched = v.findViewById(R.id.tvEventSched);
            tvMaleStocks = v.findViewById(R.id.tv_male_stocks);
            tvFemaleStocks = v.findViewById(R.id.tv_female_stocks);
            tvSoldOut = v.findViewById(R.id.tv_sold_out);
            layBar = v.findViewById(R.id.bar);
            layDetails = v.findViewById(R.id.ll_details);
            layInvite = v.findViewById(R.id.ll_invite);
            layInvited = v.findViewById(R.id.ll_invited);
            rlContent = v.findViewById(R.id.rlContent);


        }

        public void bindModel(final EventInvite event, final Click<Event> click){
            String imagePath = "";
            try{
                imagePath = (event.getImage()==null || event.getImage().size() ==0 )?
                        "" : event.getImage().get(0).getPath();

            }catch (Exception e){
                Log.e(TAG, "imagePath");
            }
            Glide.with(context).load(imagePath).into(avatar);

 /*           if(event.getImage().equals("")){
                Glide.with(context).load(imagePath).into(avatar);

            }else{
                Glide.with(context).load(R.mipmap.ic_launcher).into(avatar);
            }*/
            tvEventName.setText(event.getEventName());
            tvEventExpiry.setText(context.getString(R.string.expires_n, event.getExpiryDate()));
            tvEventHost.setText(context.getString(R.string.private_host_n, event.getPrivateHost()));
            tvInviter.setText(context.getString(R.string.invited_by_n, event.getInvitedby()));
            tvEventPrice.setText(context.getString(R.string.offer_to_pay,event.getTicketPrice()));
            String schedStartDate = event.getSchedStartDate();
            try {
                schedStartDate = TextUtils.formatDate(event.getSchedStartDate(), TextUtils.SDF_1, TextUtils.SDF_2);
            } catch (ParseException e) {
                e.printStackTrace();
            }
            String timeDuration = TextUtils.getTimeDuration(event);
            try {
                timeDuration = TextUtils.formatTime(event, TextUtils.SDF_3, TextUtils.SDF_4);
            } catch (ParseException e) {
                e.printStackTrace();
            }
            tvEventSched.setText(context.getString(R.string.event_sched_n_n,
                    schedStartDate,
                    timeDuration));
            tvMaleStocks.setText(TextUtils.getRemainingStocks(event,TextUtils.MALE));
            tvFemaleStocks.setText(TextUtils.getRemainingStocks(event,TextUtils.FEMALE));
           // tvSoldOut.setVisibility(TextUtils.getRemainingStocks(event)==0? View.VISIBLE: View.INVISIBLE);
            tvSoldOut.setText(context.getResources().getQuantityString(R.plurals.stocks,  TextUtils.getRemainingStocks(event)));


            rlContent.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    final boolean hidden = layBar.getVisibility() != View.VISIBLE;
                    if(hidden){
                        Animation slideDown = AnimationUtils.loadAnimation(context, R.anim.slide_down);
                        layBar.setVisibility(View.VISIBLE);
                        layBar.startAnimation(slideDown);

                    }else{
                        Animation slideUp = AnimationUtils.loadAnimation(context, R.anim.slide_up);
                        layBar.startAnimation(slideUp);
                        slideUp.setAnimationListener(new Animation.AnimationListener() {
                            @Override
                            public void onAnimationStart(Animation animation) {

                            }

                            @Override
                            public void onAnimationEnd(Animation animation) {
                                layBar.setVisibility(View.GONE);
                            }

                            @Override
                            public void onAnimationRepeat(Animation animation) {

                            }
                        });

                    }
                }
            });
            View.OnClickListener listener = new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                   // click.onClick(((ViewGroup)v.getParent().getParent()).findViewById(R.id.rivImage),event);
                    click.onClick(v.getId(), avatar,event);

                }
            };
            layDetails.setOnClickListener(listener);
            layInvited.setOnClickListener(listener);
            layInvite.setOnClickListener(listener);

        }
    }

}

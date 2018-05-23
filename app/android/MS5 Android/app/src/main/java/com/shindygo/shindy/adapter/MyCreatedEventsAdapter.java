package com.shindygo.shindy.adapter;

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
import com.shindygo.shindy.model.EventInvite;
import com.shindygo.shindy.utils.TextUtils;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.List;

/**
 * {@link RecyclerView.Adapter} that can display a {@link com.shindygo.shindy.model.EventInvite} and makes a call to the

 */
public class MyCreatedEventsAdapter extends RecyclerView.Adapter<MyCreatedEventsAdapter.MyViewHolder> {

    private  List<EventInvite> mValues = new ArrayList<>();

    private static final String TAG = MyCreatedEventsAdapter.class.getSimpleName();
    Context context;
    String userFbId;
    int size;
    Click<EventInvite> click;

    public MyCreatedEventsAdapter(List<EventInvite> mValues, Context context, Click<EventInvite> click) {
        this.mValues = mValues;
        this.context = context;
        this.click = click;
        this.size = mValues.size();
    }

    @Override
    public MyCreatedEventsAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        return new MyCreatedEventsAdapter.MyViewHolder(LayoutInflater.from(context).inflate(R.layout.item_created_events,null));
    }

    @Override
    public void onBindViewHolder(final MyCreatedEventsAdapter.MyViewHolder holder, final int position) {
        holder.bindModel(mValues.get(position), click);
    }

    @Override
    public int getItemCount() {
        return mValues.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder{
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

        public MyViewHolder(View v) {
            super(v);
            avatar = v.findViewById(R.id.rivImage);
            tvEventName = v.findViewById(R.id.tv_eventName);
            tvEventExpiry = v.findViewById(R.id.tvEventExpiry);
            tvEventHost = v.findViewById(R.id.tvEventHost);
           // tvInviter = v.findViewById(R.id.tvInviter);
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

        public void bindModel(final EventInvite event, final Click<EventInvite> click){
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
           // tvInviter.setText(context.getString(R.string.invited_by_n, event.getInvitedby()));
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


        @Override
        public String toString() {
            return super.toString() + " '" + tvEventName.getText() + "'";
        }
    }
}

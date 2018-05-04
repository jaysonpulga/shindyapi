package com.shindygo.shindy.main.adapter;

/**
 * Created by User on 16.03.2018.
 */

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.shindygo.shindy.R;
import com.shindygo.shindy.interfaces.ClickCard;

import java.util.Timer;
import java.util.logging.Handler;
import java.util.logging.LogRecord;

/**
 * Created by Sergey on 24.10.2017.
 */

public class EventUserAdapter extends RecyclerView.Adapter<EventUserAdapter.EventUserHolder> {
    Context context;
    ClickCard clickCard;

    public EventUserAdapter(ClickCard clickCard) {
        this.clickCard = clickCard;
    }

    @Override
    public EventUserAdapter.EventUserHolder onCreateViewHolder(ViewGroup parent, int viewType) {

        context=parent.getContext();

        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_event_user,null);

        return new EventUserAdapter.EventUserHolder(view);
    }

    @Override
    public void onBindViewHolder(final EventUserHolder holder, final int position) {
        holder.bindModel(clickCard);


    }

    @Override
    public int getItemCount() {
        return 10;
    }

    public class EventUserHolder extends RecyclerView.ViewHolder{
        ImageView imageView,arrow;
        TextView textView;

        public EventUserHolder(View v) {
            super(v);
        imageView = v.findViewById(R.id.image);

        }
        public void bindModel(final ClickCard clickCard){
            imageView.setOnTouchListener(new View.OnTouchListener() {
                @Override
                public boolean onTouch(View view, MotionEvent motionEvent) {
                    //view_.setVisibility(view_.getVisibility()==View.VISIBLE?View.GONE:View.VISIBLE);
                    clickCard.Click(true);
                    imageView.setSelected(true);
                    return false;
                }
            });

        }
    }

}

package com.shindygo.shindy.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RatingBar;
import android.widget.TextView;

import com.shindygo.shindy.R;
import com.shindygo.shindy.model.Review;

import java.util.List;

/**
 * {@link RecyclerView.Adapter} that can display a {@link Review} and makes a call to the

 */
public class ReviewRecyclerViewAdapter extends RecyclerView.Adapter<ReviewRecyclerViewAdapter.ViewHolder> {
    private static final String TAG = "ReviewAdapter";
    private final List<Review> mValues;


    public ReviewRecyclerViewAdapter(List<Review> items, Context context) {
        mValues = items;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_review, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final ViewHolder holder, int position) {
        holder.mItem = mValues.get(position);
        holder.tvName.setText(holder.mItem.getUserName());
        holder.tvComment.setText(holder.mItem.getComment());
        holder.tvDateCreated.setText(holder.mItem.getUserName());
        try {
            holder.rbRating.setRating(Float.parseFloat(holder.mItem.getRate()));

        }catch (Exception e){
            e.printStackTrace();
        }
        holder.mView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Log.v(TAG, "onCLick");
            }
        });
    }

    @Override
    public int getItemCount() {
        return mValues.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        public final View mView;
        public final TextView tvName;
        public final TextView tvComment;
        public final TextView tvDateCreated;
        public final RatingBar rbRating;
        public Review mItem;

        public ViewHolder(View view) {
            super(view);
            mView = view;
            tvComment = (TextView) view.findViewById(R.id.tv_comment);
            tvName = (TextView) view.findViewById(R.id.tv_name);
            tvDateCreated = (TextView) view.findViewById(R.id.tv_comment);
            rbRating = (RatingBar) view.findViewById(R.id.rbReview);
        }

        @Override
        public String toString() {
            return super.toString() + " '" + tvComment.getText() + "'";
        }
    }
}

package com.shindygo.shindy.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.makeramen.roundedimageview.RoundedImageView;
import com.shindygo.shindy.R;
import com.shindygo.shindy.interfaces.Click;
import com.shindygo.shindy.interfaces.Comment;
import com.shindygo.shindy.model.Discussion;

import java.util.List;

/**
 * {@link RecyclerView.Adapter} that can display a {@link Discussion} and makes a call to the
 * specified .
 * TODO: Replace the implementation with code for your data type.
 */
public class DiscussionRecyclerViewAdapter extends RecyclerView.Adapter<DiscussionRecyclerViewAdapter.ViewHolder> {

    private final List<Comment> mValues;
    private Click<Comment> click;
    private Context context;

    public DiscussionRecyclerViewAdapter(List<Comment> items, Context context, Click<Comment> click) {
        mValues = items;
        this.context = context;
        this.click = click;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_discussion, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final ViewHolder holder, int position) {

        holder.mItem = mValues.get(position);
        holder.tvName.setText(mValues.get(position).getUserName());
        holder.tvComment.setText(mValues.get(position).getComment());
        Glide.with(context).load(mValues.get(position).getPhotoPath()).into(holder.rivAvatar);
        holder.rvReply.setVisibility(mValues.get(position).hasReply()? View.VISIBLE: View.GONE);
        holder.mView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(click==null)return;;
                click.onClick(v.getId(), v,holder.mItem);
            }
        });
    }

    @Override
    public int getItemCount() {
        return mValues.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        public final View mView;
        public final RoundedImageView rivAvatar;
        public final TextView tvName;
        public final TextView tvComment;
        public final TextView tvDateCreated;
        public final RecyclerView rvReply;

        public Comment mItem;

        public ViewHolder(View view) {
            super(view);
            mView = view;
            tvName = (TextView) view.findViewById(R.id.tv_name);
            tvComment = (TextView) view.findViewById(R.id.content);
            tvDateCreated = (TextView) view.findViewById(R.id.tv_date_created);
            rivAvatar = (RoundedImageView) view.findViewById(R.id.iv_avatar);
            rvReply = (RecyclerView) view.findViewById(R.id.rv_reply);


        }

        @Override
        public String toString() {
            return super.toString() + " '" + tvComment.getText() + "'";
        }
    }
}

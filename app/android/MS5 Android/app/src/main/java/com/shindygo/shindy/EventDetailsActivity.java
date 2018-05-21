package com.shindygo.shindy;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.drawable.BitmapDrawable;
import android.os.Build;
import android.os.Bundle;
import android.support.design.widget.CollapsingToolbarLayout;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.ActivityOptionsCompat;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.content.res.ResourcesCompat;
import android.support.v4.view.ViewCompat;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.graphics.Palette;
import android.support.v7.widget.Toolbar;
import android.transition.Slide;
import android.util.Log;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RatingBar;
import android.widget.TextView;

import com.google.gson.Gson;
import com.rahimlis.badgedtablayout.BadgedTabLayout;
import com.shindygo.shindy.model.Event;
import com.shindygo.shindy.model.EventInvite;
import com.shindygo.shindy.utils.TextUtils;
import com.squareup.picasso.Callback;
import com.squareup.picasso.Picasso;

import butterknife.BindView;
import butterknife.ButterKnife;

public class EventDetailsActivity extends AppCompatActivity  {
    private static final String TAG =EventDetailsActivity.class.getSimpleName();


/*    @BindView(R.id.title)
    TextView title;
    @BindView(R.id.toolbar)
    Toolbar toolbar;
     ImageView imageViewMenu;
    TextView menuName;*/

    @BindView(R.id.tabs)
    BadgedTabLayout tabs;
    EventInvite event;
    @BindView(R.id.tv_eventName)
    TextView tvEventName;
    @BindView(R.id.tvEventHost)
    TextView tvEventHost;
    @BindView(R.id.ratingBar)
    RatingBar rbRating;
    @BindView(R.id.tv_male_stocks)
    TextView tvMaleStocks;
    @BindView(R.id.tv_female_stocks)
    TextView tvFemaleStocks;
    @BindView(R.id.tv_sold_out)
    TextView tvSoldOut;
    @BindView(R.id.ll_like)
    LinearLayout layLike;
    @BindView(R.id.tvLike)
    TextView tvLike;
    @BindView(R.id.ivLike)
    ImageView ivLike;
    @BindView(R.id.ll_invite)
    LinearLayout layInvite;
    @BindView(R.id.ll_invited)
    LinearLayout layInvited;
    @BindView(R.id.ll_im_in)
    LinearLayout layIn;
    @BindView(R.id.tvImIn)
    TextView tvIn;
    @BindView(R.id.ivImIn)
    ImageView ivIn;
    @BindView(R.id.ll_block)
    LinearLayout layBlock;
    @BindView(R.id.tvBlock)
    TextView tvBlock;
    @BindView(R.id.ivBlock)
    ImageView ivBlock;

    CollapsingToolbarLayout collapsingToolbarLayout;

    private static final String EXTRA_IMAGE = "com.shindygo.shindy.extraImage";
    private static final String EXTRA_TITLE = "com.shindygo.shindy.extraTitle";
    private static final String EXTRA_MODEL = "com.shindygo.shindy.extraModel";


    int primary;
    int primaryDark;

    public static void navigate(AppCompatActivity activity, View transitionImage, EventInvite viewModel) {
        Intent intent = new Intent(activity, EventDetailsActivity.class);
        intent.putExtra(EXTRA_IMAGE, viewModel.getImage().get(0).getPath());
        intent.putExtra(EXTRA_TITLE, viewModel.getEventName());
        String json = viewModel.toJSON();
        Log.v(TAG,json );
        intent.putExtra(EXTRA_MODEL, json);

        activity.startActivity(intent);
        activity.overridePendingTransition( R.anim.left_out, R.anim.left_in );
       /* ActivityOptionsCompat options = ActivityOptionsCompat.makeSceneTransitionAnimation(activity, transitionImage, EXTRA_IMAGE);
        ActivityCompat.startActivity(activity, intent, options.toBundle());*/
    }

    private SectionsPagerAdapter mSectionsPagerAdapter;
    private ViewPager mViewPager;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Api.initialized(getApplicationContext());
        setContentView(R.layout.activity_event_details);
        ButterKnife.bind(this);
        overridePendingTransition(R.anim.left_in, R.anim.left_out);
        ViewCompat.setTransitionName(findViewById(R.id.appBar), EXTRA_IMAGE);
        supportPostponeEnterTransition();
        setSupportActionBar((Toolbar) findViewById(R.id.toolbar));
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        String itemTitle = getIntent().getStringExtra(EXTRA_TITLE);
        String model = getIntent().getStringExtra(EXTRA_MODEL);
        event = new Gson().fromJson(model, EventInvite.class);
        if(event==null){
            Log.v(TAG, "event ==null");

        }
        Log.v(TAG, "eventName "+event.getEventName());

        collapsingToolbarLayout = (CollapsingToolbarLayout) findViewById(R.id.collapsingToolbar);
        collapsingToolbarLayout.setTitle(itemTitle);
        collapsingToolbarLayout.setExpandedTitleColor(getResources().getColor(android.R.color.transparent));


/*        Picasso.with(this).load(getIntent().getStringExtra(EXTRA_IMAGE)).into(image, new Callback() {
                    @Override
                    public void onSuccess() {
                        Bitmap bitmap = ((BitmapDrawable) image.getDrawable()).getBitmap();
                        Palette.from(bitmap).generate(new Palette.PaletteAsyncListener() {
                            public void onGenerated(Palette palette) {
                                applyPalette(palette);
                                collapsingToolbarLayout.setContentScrimColor(palette.getMutedColor(primary));
                                collapsingToolbarLayout.setStatusBarScrimColor(palette.getDarkMutedColor(primaryDark));
                            }
                        });
                    }

            @Override
            public void onError() {

            }
        });*/
       // setSupportActionBar(toolbar);

       // Glide.with(getApplicationContext()).load(url).into(imageViewMenu);


        // Create the adapter that will return a fragment for each of the three
        // primary sections of the activity.
        mSectionsPagerAdapter = new SectionsPagerAdapter(getSupportFragmentManager());

        // Set up the ViewPager with the sections adapter.
        mViewPager = findViewById(R.id.container);
        mViewPager.setAdapter(mSectionsPagerAdapter);

        tabs.setupWithViewPager(mViewPager);


//        tabLayout.setTabFont(ResourcesCompat.getFont(this, R.font.trench));
//        tabs.setBadgeTruncateAt(TextUtils.TruncateAt.MIDDLE);

        setViewContent(event);
    }

    public void setTabBadgeText(int index, String text){
     //   tabs.setBadgeText(index, text);
    }


    public void onBackPressed() {
        super.onBackPressed();
        //overridePendingTransition(R.anim.right_in, R.anim.right_out);

    }

    /**
     * Let's the user tap the activity icon to go 'home'.
     * Requires setHomeButtonEnabled() in onCreate().
     */
    @Override
    public boolean onOptionsItemSelected(MenuItem menuItem) {
        switch (menuItem.getItemId()) {
            case android.R.id.home:
                // ProjectsActivity is my 'home' activity
                onBackPressed();
                return true;
        }
        return (super.onOptionsItemSelected(menuItem));
    }


    public void setViewContent(EventInvite event) {
        if(event==null)return;
        tvEventName.setText(event.getEventName());
        tvEventHost.setText(getString(R.string.hosted_by_n, event.getPrivateHost()));
        float r = 0;
        try {
            r = Float.parseFloat(event.getRating());
        }catch (Exception e){
            e.printStackTrace();
        }
        rbRating.setRating(r);
        tvFemaleStocks.setText(TextUtils.getRemainingStocks(event, TextUtils.FEMALE));
        tvMaleStocks.setText(TextUtils.getRemainingStocks(event, TextUtils.MALE));


    }



    /**
     * A {@link FragmentPagerAdapter} that returns a fragment corresponding to
     * one of the sections/tabs/pages.
     */
    public class SectionsPagerAdapter extends FragmentPagerAdapter {

        public SectionsPagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public Fragment getItem(int position) {
            // getItem is called to instantiate the fragment for the given page.
            // Return a PlaceholderFragment (defined as a static inner class below).
            switch (position) {
                case 0:
                    return EventDetailsFragment.newInstance(event);
                case 1:
                    return DiscussionFragment.newInstance(String.valueOf(position), "1");
                case 2:
                    return ReviewFragment.newInstance(String.valueOf(position));
                default:
                    return EventDetailsFragment.newInstance(event);
            }
        }

        @Override
        public int getCount() {
            // Show 3 total pages.
            return 3;
        }

        @Override
        public CharSequence getPageTitle(int position) {
            switch (position) {
                case 0:
                    return getString(R.string.details);
                case 1:
                    return getString(R.string.discussion);
                case 2:
                    return getString(R.string.reviews);
            }
            return null;
        }
    }

    @Override public boolean dispatchTouchEvent(MotionEvent motionEvent) {
        try {
            return super.dispatchTouchEvent(motionEvent);
        } catch (NullPointerException e) {
            return false;
        }
    }

    private void initActivityTransitions() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            Slide transition = new Slide();
            transition.excludeTarget(android.R.id.statusBarBackground, true);
            getWindow().setEnterTransition(transition);
            getWindow().setReturnTransition(transition);
        }
    }

    private void applyPalette(Palette palette) {
        primaryDark = getResources().getColor(R.color.colorPrimaryDark);
        primary = getResources().getColor(R.color.colorPrimary);
        collapsingToolbarLayout.setContentScrimColor(palette.getMutedColor(primary));
        collapsingToolbarLayout.setStatusBarScrimColor(palette.getDarkMutedColor(primaryDark));
        supportStartPostponedEnterTransition();
    }

}

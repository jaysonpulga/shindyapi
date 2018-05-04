package com.shindygo.shindy;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.RequiresApi;
import android.support.design.widget.NavigationView;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.GravityCompat;
import android.support.v4.view.ViewPager;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Gravity;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.facebook.Profile;
import com.facebook.login.LoginManager;
import com.rahimlis.badgedtablayout.BadgedTabLayout;
import com.shindygo.shindy.main.MyShindigsFragment;
import com.shindygo.shindy.main.NewUsersFragment;
import com.shindygo.shindy.main.UsersFragment;
import com.shindygo.shindy.utils.FontUtils;

import butterknife.BindView;
import butterknife.ButterKnife;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener, MyShindigsFragment.OnFragmentInteractionListener, UsersFragment.OnFragmentInteractionListener, NewUsersFragment.OnFragmentInteractionListener {


    @BindView(R.id.title)
    TextView title;
    @BindView(R.id.toolbar)
    Toolbar toolbar;
    @BindView(R.id.tabs)
    BadgedTabLayout tabs;
    @BindView(R.id.container)
    ViewPager container;
    @BindView(R.id.nav_view)
    NavigationView navView;
    @BindView(R.id.drawer_layout)
    DrawerLayout drawerLayout;
    private SectionsPagerAdapter mSectionsPagerAdapter;
    private ViewPager mViewPager;
    ImageView imageViewMenu;
    TextView menuName;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        ButterKnife.bind(this);
        setSupportActionBar(toolbar);
        Profile.getCurrentProfile();
        if (Profile.getCurrentProfile()==null){
            Intent intent
                    = new Intent(MainActivity.this,LoginActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            finish();
        }
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();
        imageViewMenu = navView.getHeaderView(0).findViewById(R.id.imageView);
        navView.setNavigationItemSelectedListener(this);
        navView.getHeaderView(0).findViewById(R.id.imageView);
        final SharedPreferences sharedPref = getSharedPreferences("set", Context.MODE_PRIVATE);
        final String url = sharedPref.getString("url", "");
        Glide.with(getApplicationContext()).load(url).into(imageViewMenu);
        menuName = navView.getHeaderView(0).findViewById(R.id.menuName);
        menuName.setText(sharedPref.getString("name",""));
        // Create the adapter that will return a fragment for each of the three
        // primary sections of the activity.
        mSectionsPagerAdapter = new SectionsPagerAdapter(getSupportFragmentManager());

        // Set up the ViewPager with the sections adapter.
        mViewPager = findViewById(R.id.container);
        mViewPager.setAdapter(mSectionsPagerAdapter);

        tabs.setupWithViewPager(mViewPager);
        tabs.setBadgeText(2, "13");

//        tabLayout.setTabFont(ResourcesCompat.getFont(this, R.font.trench));
//        tabs.setBadgeTruncateAt(TextUtils.TruncateAt.MIDDLE);
        FontUtils.setFont(navView, FontUtils.Roboto_Thin);
        FontUtils.setFont(drawer, FontUtils.Roboto_Light);
        FontUtils.setFont(title, FontUtils.Be_Bright);

    }

    void openenDrawer()
    {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.openDrawer(GravityCompat.START);
    }
    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            
            drawer.closeDrawer(GravityCompat.START);
        } else {
            if (getFragmentManager().getBackStackEntryCount() > 0) {
                getFragmentManager().popBackStack();
            }
            else
                super.onBackPressed();
        }
    }
/*

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }
*/

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();
        switch (id) {
            case R.id.nav_profile_preferences: {
                FragmentManager fm  = getSupportFragmentManager();
                Fragment fragment = new ProfileActivity();
                fm.beginTransaction()
                        .replace(R.id.frame,fragment)
                        .addToBackStack("my_fragment")
                        .commit();
                break;
            }
            case R.id.nav_logout: {
                LoginManager.getInstance().logOut();
                Intent login = new Intent(MainActivity.this, LoginActivity.class);
                startActivity(login);
                finish();
                break;
            }
            case R.id.nav_users_mgmt:
            {
                FragmentManager fm  = getSupportFragmentManager();
                Fragment fragment = new UsersMGMTActivity();
                fm.beginTransaction()
                        .replace(R.id.frame,fragment)
                        .addToBackStack("my_fragment")
                        .commit();
                break;
            }
            case R.id.nav_shindigs:
                Fragment fragment= getSupportFragmentManager().findFragmentById(R.id.frame);
                if (fragment!=null)
                getSupportFragmentManager().beginTransaction().remove(fragment).commit();
                break;
            case R.id.nav_event_mgmt:
//                FragmentManager fm  = getSupportFragmentManager();
//                Fragment fragment = new EventFeedbackActivity();
//                fm.beginTransaction()
//                        .replace(R.id.frame,fragment)
//                        .addToBackStack("my_fragment")
//                        .commit();
                break;
        }
        /*if (id == R.id.nav_camera) {
            // Handle the camera action
        } else if (id == R.id.nav_gallery) {

        } else if (id == R.id.nav_slideshow) {

        } else if (id == R.id.nav_manage) {

        } else if (id == R.id.nav_share) {

        } else if (id == R.id.nav_send) {

        }
*/
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    @Override
    public void onFragmentInteraction(Uri uri) {

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
                    return MyShindigsFragment.newInstance(String.valueOf(position), "1");
                case 1:
                    return UsersFragment.newInstance(String.valueOf(position), "1");
                case 2:
                    return NewUsersFragment.newInstance(String.valueOf(position), "1");
                default:
                    return MyShindigsFragment.newInstance(String.valueOf(position), "1");
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
                    return getString(R.string.my_shindigs);
                case 1:
                    return getString(R.string.users);
                case 2:
                    return getString(R.string.new_users);
            }
            return null;
        }
    }
}

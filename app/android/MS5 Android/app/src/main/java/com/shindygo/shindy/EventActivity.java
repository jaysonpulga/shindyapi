package com.shindygo.shindy;


import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.annotation.RequiresApi;
import android.support.design.widget.Snackbar;
import android.support.design.widget.TextInputEditText;
import android.support.v4.app.Fragment;
import android.text.Editable;
import android.text.InputFilter;
import android.text.TextWatcher;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.PopupWindow;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.TimePicker;

import com.esafirm.imagepicker.features.ImagePicker;
import com.esafirm.imagepicker.features.IpCons;
import com.shindygo.shindy.model.Event;
import com.shindygo.shindy.model.EventInvite;
import com.shindygo.shindy.model.Image;
import com.shindygo.shindy.model.User;
import com.shindygo.shindy.utils.FontUtils;
import com.shindygo.shindy.utils.PicassoLoader;
import com.shindygo.shindy.utils.TextUtils;

import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import cn.lightsky.infiniteindicator.IndicatorConfiguration;
import cn.lightsky.infiniteindicator.InfiniteIndicator;
import cn.lightsky.infiniteindicator.Page;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static cn.lightsky.infiniteindicator.IndicatorConfiguration.LEFT;

public class EventActivity extends Fragment  {

    private static final String TAG = "EventActivity";
    private static final int RQC_IMG_CHOOSER = IpCons.RC_IMAGE_PICKER;



    @BindView(R.id.back)
    ImageView back;
    @BindView(R.id.title)
    TextView title;
    @BindView(R.id.top)
    LinearLayout top;
    @BindView(R.id.iv_add_photo)
    FrameLayout ivAddPhoto;
    @BindView(R.id.imgDateStart)
    ImageView imgDateStart;
    @BindView(R.id.tvDateStart)
    TextView tvDateStart;
    @BindView(R.id.tvTimeStart)
    TextView tvTimeStart;
    @BindView(R.id.imgDateEnd)
    ImageView imgDateEnd;
    @BindView(R.id.tvDateEnd)
    TextView tvDateEnd;
    @BindView(R.id.tvTimeEnd)
    TextView tvTimeEnd;
    @BindView(R.id.imgExpiry)
    ImageView imgExpiry;
    @BindView(R.id.tvDateExpire)
    TextView tvDateExpire;
    @BindView(R.id.imgLocation)
    ImageView imgLocation;
    TextInputEditText etLocation;
    @BindView(R.id.imgCoHost)
    ImageView imgCohost;
    TextInputEditText etCoHost;
    @BindView(R.id.imgTicketPrice)
    ImageView imgTicketPrice;
    TextInputEditText etTicketPrice;
    TextInputEditText etMaxMale;
    TextInputEditText etMaxFemale;
    TextInputEditText etWebsite;
    @BindView(R.id.et_description)
    EditText etDescription;
    @BindView(R.id.bt_save)
    Button btnSave;
    @BindView(R.id.pbLayout)
    FrameLayout pbLayout;
    @BindView(R.id.progress_bar)
    ProgressBar progressBar;


    @BindView(R.id.imgCancel)
    ImageView imgCancel;
    @BindView(R.id.tvCancel)
    TextView tvCancel;
    @BindView(R.id.et_zip)
    TextView etZipcode;
    @BindView(R.id.tv_left)
    TextView tvLeft;
    @BindView(R.id.cpAbleInvite)
    CheckBox cpAbleInvite;



    TextInputEditText etEventName;

    InfiniteIndicator sliderImages;
    private ArrayList<Page> pageViews;


    private PopupWindow mPopupWindow;
    private RelativeLayout mRelativeLayout;
    private Api api;
    private Event event ;
    private boolean saving;

    @RequiresApi(api = Build.VERSION_CODES.M)
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, Bundle savedInstanceState) {
        final View view = inflater.inflate(R.layout.activity_event, container, false);
        ButterKnife.bind(this, view);
        FontUtils.setFont(title, FontUtils.Be_Bright);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                ((MainActivity) getActivity()).openenDrawer();
            }
        });
        etDescription.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                tvLeft.setText(131-charSequence.length() + " character left");
            }

            @Override
            public void afterTextChanged(Editable editable) {
                tvLeft.setText(131-editable.length() + " character left");

            }
        });
        final Calendar calendar = Calendar.getInstance();
        //final Date date = calendar.getTime();
        View.OnClickListener onClickDateView = new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                DatePickerDialog dialog =  new DatePickerDialog(getContext(), dateSetListener, calendar
                        .get(Calendar.YEAR), calendar.get(Calendar.MONTH),
                        calendar.get(Calendar.DAY_OF_MONTH));
                dialog.getDatePicker().setId(v.getId());
                dialog.show();
            }
        };

        tvDateStart.setOnClickListener(onClickDateView);
        tvDateEnd.setOnClickListener(onClickDateView);
        tvDateExpire.setOnClickListener(onClickDateView);
        tvTimeEnd.setOnClickListener(new View. OnClickListener() {

            @Override
            public void onClick(final View v) {
                // TODO Auto-generated method stub
                Calendar mcurrentTime = Calendar.getInstance();
                int hour = mcurrentTime.get(Calendar.HOUR_OF_DAY);
                int minute = mcurrentTime.get(Calendar.MINUTE);
                TimePickerDialog mTimePicker = new TimePickerDialog(getContext(), new TimePickerDialog.OnTimeSetListener() {
                    @Override
                    public void onTimeSet(TimePicker timePicker, int selectedHour, int selectedMinute) {
                        try {

                            Calendar calendar = Calendar.getInstance();
                            calendar.set(Calendar.HOUR, selectedHour);
                            calendar.set(Calendar.MINUTE, selectedMinute);
                            //  calendar.set(Calendar.SECOND, dayOfMonth);
                            SimpleDateFormat sdf = new SimpleDateFormat(TextUtils.SDF_4);

                           // ((TextView)getView().findViewById(v.getId()))
                            ((TextView)v).setText(sdf.format(calendar.getTime()));
                        }catch (NullPointerException e){
                            e.printStackTrace();
                        }

                    }
                }, hour, minute, true);//Yes 24 hour time
                mTimePicker.setTitle("Select Time");
                //mTimePicker.findViewById(com.android.internal.R.id.timePicker).setId(v.getId());

                mTimePicker.show();
                //mTimePicker.findViewById(com.android.internal.R.id.timePicker).setId(v.getId());
            }
        });
        tvTimeStart.setOnClickListener(new View. OnClickListener() {

            @Override
            public void onClick(final View v) {
                // TODO Auto-generated method stub
                Calendar mcurrentTime = Calendar.getInstance();
                int hour = mcurrentTime.get(Calendar.HOUR_OF_DAY);
                int minute = mcurrentTime.get(Calendar.MINUTE);
                TimePickerDialog mTimePicker = new TimePickerDialog(getContext(), new TimePickerDialog.OnTimeSetListener() {
                    @Override
                    public void onTimeSet(TimePicker timePicker, int selectedHour, int selectedMinute) {
                        try {

                            Calendar calendar = Calendar.getInstance();
                            calendar.set(Calendar.HOUR, selectedHour);
                            calendar.set(Calendar.MINUTE, selectedMinute);
                            //  calendar.set(Calendar.SECOND, dayOfMonth);
                            SimpleDateFormat sdf = new SimpleDateFormat(TextUtils.SDF_4);

                            // ((TextView)getView().findViewById(v.getId()))
                            ((TextView)v).setText(sdf.format(calendar.getTime()));
                        }catch (NullPointerException e){
                            e.printStackTrace();
                        }

                    }
                }, hour, minute, true);//Yes 24 hour time
                mTimePicker.setTitle("Select Time");
                //mTimePicker.findViewById(com.android.internal.R.id.timePicker).setId(v.getId());

                mTimePicker.show();
                //mTimePicker.findViewById(com.android.internal.R.id.timePicker).setId(v.getId());
            }
        });



        etCoHost = view.findViewById(R.id.et_co_host);
        etEventName = view.findViewById(R.id.etEventName);
        etLocation = view.findViewById(R.id.etLocation);
        etMaxFemale = view.findViewById(R.id.et_max_female);
        etMaxMale = view.findViewById(R.id.et_max_male);
        etWebsite = view.findViewById(R.id.etWeb);
        etTicketPrice = view.findViewById(R.id.et_ticket_price);
        etTicketPrice.addTextChangedListener(new TextWatcher() {
            public void onTextChanged(CharSequence arg0, int arg1, int arg2,int arg3) {

            }
            public void beforeTextChanged(CharSequence arg0, int arg1,int arg2, int arg3) {

            }

            public void afterTextChanged(Editable arg0) {
                if (arg0.length() > 0) {
                    int count = -1;

                    String str = etTicketPrice.getText().toString();
                    etTicketPrice.setOnKeyListener(new View.OnKeyListener() {


                        public boolean onKey(View v, int keyCode, KeyEvent event) {
                            int count = -1;

                            if (keyCode == KeyEvent.KEYCODE_DEL) {
                                count--;
                                InputFilter[] fArray = new InputFilter[1];
                                fArray[0] = new InputFilter.LengthFilter(100);
                                etTicketPrice.setFilters(fArray);
                                //change the edittext's maximum length to 100.
                                //If we didn't change this the edittext's maximum length will
                                //be number of digits we previously entered.
                            }
                            return false;
                        }
                    });
                    char t = str.charAt(arg0.length() - 1);
                    if (t == '.') {
                        count = 0;
                    }
                    if (count >= 0) {
                        if (count == 2) {
                            InputFilter[] fArray = new InputFilter[1];
                            fArray[0] = new InputFilter.LengthFilter(arg0.length());
                            etTicketPrice.setFilters(fArray);
                            //prevent the edittext from accessing digits
                            //by setting maximum length as total number of digits we typed till now.
                        }
                        count++;
                    }
                }
            }
        });
        ivAddPhoto.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                openImageChooser();
            }
        });
        btnSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(!((MainActivity) getActivity()).isConnectedOrConnecting(getActivity())){
                    ((MainActivity) getActivity()).showDialog("require internet");
                    return;
                }
                if(saving){
                    return;
                }
                saving = true;
               // if(progressBar.getVisibility()== View.VISIBLE)return;
                showProgressBar(true);

                saveToRemote(create());

            }
        });

        sliderImages = (InfiniteIndicator) view.findViewById(R.id.infinite_anim_circle);


        return view;
    }

    private void showProgressBar(boolean show) {
        //if(getView()==null)return;
        try{
            Log.v(TAG, "showProgressBar "+ show);
            pbLayout.setVisibility(show? View.VISIBLE: View.GONE);
            progressBar.setVisibility(show? View.VISIBLE: View.GONE);

        }catch (NullPointerException e){
            e.printStackTrace();
        }
    }


    private void saveToRemote(Event event) {
        Api.getInstance().createEvent(event, new Callback<JSONObject>() {
            @Override
            public void onResponse(Call<JSONObject> call, Response<JSONObject> response) {
                Log.v(TAG,"onResponse");
                if(response!=null){
                    Log.v(TAG,"onResponse " +response.message());
                    try {
                        Log.v(TAG,"onResponse " +response.isSuccessful());

                        if(response.isSuccessful()){
                            if(getView()!=null)
                                Snackbar.make(getView().findViewById(R.id.rl), R.string.event_successfully_created, Snackbar.LENGTH_LONG).show();
                            getActivity().onBackPressed();
                        }
                    }catch (NullPointerException e){
                        e.printStackTrace();
                    }
                }
                showProgressBar(false);
            }

            @Override
            public void onFailure(Call<JSONObject> call, Throwable t) {
                Log.e(TAG, "failed to create event");
                Log.e(TAG, t.getMessage());
                showProgressBar(false);

                try {

                    if(getView()!=null)
                            Snackbar.make(getView().findViewById(R.id.rl),
                                    R.string.please_try_again, Snackbar.LENGTH_LONG).show();

                }catch (NullPointerException e){
                    e.printStackTrace();
                }
            }
        });
    }

    private void openImageChooser() {
        ImagePicker.create(EventActivity.this)
             //   .returnMode(ReturnMode.ALL) // set whether pick action or camera action should return immediate result or not. Only works in single mode for image picker
                .folderMode(true) // set folder mode (false by default)
                .toolbarFolderTitle("Folder") // folder selection title
                .toolbarImageTitle("Choose Images")
               // .imageLoader(new GrayscaleImageLoader())
                .start(RQC_IMG_CHOOSER); // image selection title
    }

    private void imageSlider(ArrayList<Page> pageViews){
        IndicatorConfiguration configuration = new IndicatorConfiguration.Builder()
                .imageLoader(new PicassoLoader())
                .isStopWhileTouch(true)
              //  .onPageChangeListener(this)
              //  .onPageClickListener(this)
                .direction(LEFT)
                .position(IndicatorConfiguration.IndicatorPosition.Center_Bottom)
                .build();
        sliderImages.init(configuration);
        sliderImages.notifyDataChange(pageViews);
        //sliderImages.setCurrentItem(2);
    }

    DatePickerDialog.OnDateSetListener dateSetListener = new DatePickerDialog.OnDateSetListener() {

        @Override
        public void onDateSet(DatePicker view, int year, int monthOfYear,
                              int dayOfMonth) {
            Calendar calendar = Calendar.getInstance();
            calendar.set(Calendar.YEAR, year);
            calendar.set(Calendar.MONTH, monthOfYear);
            calendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
            try {
                SimpleDateFormat sdf = new SimpleDateFormat(TextUtils.SDF_1);

                ((TextView)getView().findViewById(view.getId())).setText(sdf.format(calendar.getTime()));
            }catch (NullPointerException e){
                e.printStackTrace();
            }

        }

    };


    private Event create() {
        event = new Event();
        event.setUserFbId(User.getCurrentUserId());
        event.setEventName(getText(etEventName));
        event.setAddress(getText(etLocation));
        /*String longitude;	                //Longitude (return on map api)
        String lat;                         //Latitude (return on map api)
        String zipCode;                 //*	zipcode (return on map api)*/

        List<Image> image;	                //url image path

        event.setZipCode(getText(etZipcode));

        event.setDescription(getText(etDescription));
  //      String notes;                   //	sample event notes
        event.setTicketPrice(getText(etTicketPrice));
        event.setRepresentative(etCoHost.getTag()==null?"": (String) etCoHost.getTag());
        SimpleDateFormat sdf1 = new SimpleDateFormat(TextUtils.SDF_1);
        event.setCreateDate(sdf1.format(new Date()));

        event.setExpiryDate(getText(tvDateExpire));
       // String expiryDate;              //	2018-02-01
        event.setSchedStartDate(getText(tvDateStart));

        //  String schedStartDate;         //	2018-01-01
        event.setStartTime(getText(tvTimeStart));
        event.setSchedEndDate(getText(tvDateEnd));
        event.setEndTime(getText(tvTimeEnd));
        event.setMaxMale(getText(etMaxMale));
        event.setMaxFemale(getText(etMaxFemale));
        event.setWebsiteUrl(getText(etWebsite));
        event.setAbleGuestInvite(cpAbleInvite.isChecked()? "1":"0");
        event.setImage(Image.from(pageViews));
        event.setNotes("");
        event.setEventId("");


        //    String startTime ;             //	10:00 AM
   //     String schedEndDate;           //	optional for this field, sample(2018-01-01)
   //     String endTime;                //	optional for this field, sample value(13:00 PM)

     //   String spotAvailable ;         //	5
/*
        String maxMale ;               //	4

        String     maxFemale  ;            //	8
        String websiteUrl  ;           //	www.sample.com

        String eventId;               //
        String ableGuestInvite;*/

    return event;

    }

    String getText(TextView tv){
        try {
            return tv.getText().toString();
        }catch (NullPointerException e){
            e.printStackTrace();
        }
        return "";
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        Log.v(TAG, "onActivityResult requestCode:" +requestCode
                                    + " resultCode:"+resultCode
                                    + "  intent=="+String.valueOf(data==null));
        if (ImagePicker.shouldHandle(requestCode, resultCode, data)) {
            // Get a list of picked images
            //List<Image> images = Image.from(ImagePicker.getImages(data));
            try {
                if(pageViews==null)pageViews = new ArrayList<>();
                Log.v(TAG, "onActivityResult ImagePicker");

                pageViews.addAll(Image.fromImagePickerToPage(ImagePicker.getImages(data)));
                if(pageViews!=null){
                    Log.v(TAG, "onActivityResult pagviews != null");
                    Log.v(TAG, "page.res " + pageViews.get(0).res  );
                    Log.v(TAG, "page.data " + pageViews.get(0).data  );

                    imageSlider(pageViews);
                }
            }catch (Exception e){
                e.printStackTrace();
            }

        }

        super.onActivityResult(requestCode, resultCode, data);
    }


    //To avoid memory leak ,you should release the res
    @Override
    public void onPause() {
        super.onPause();
        sliderImages.stop();
    }

    @Override
    public void onResume() {
        super.onResume();
        try  {
            sliderImages.start();
        }catch (NullPointerException e){
            e.printStackTrace();
        }
    }

}

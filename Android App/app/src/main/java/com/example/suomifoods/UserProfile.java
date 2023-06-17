package com.example.suomifoods;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.material.navigation.NavigationView;
import com.google.android.material.textfield.TextInputEditText;
import com.vishnusivadas.advanced_httpurlconnection.PutData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class UserProfile extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener{

    DrawerLayout drawerLayout;
    NavigationView navigationView;
    Toolbar toolbar;
    String id, link, email;
    ProgressBar progressBar;
    TextInputEditText nic, fullName, emailAddress, phoneNo, address, age;
    Button edit, update;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_user_profile);

        Intent intent = getIntent();
        id = intent.getStringExtra("id");
        email = intent.getStringExtra("email");

        initialize();
        navigationDrawer();
        buttonClick();

        getUserData(id);
        disableEditTexts();

    }

    private void initialize(){
        try {

            IpAddress ipA = new IpAddress();
            link = ipA.getAddress();

            drawerLayout = findViewById(R.id.drawer_layout);
            navigationView = findViewById(R.id.nav_view);
            toolbar = findViewById(R.id.toolbar);

            nic = findViewById(R.id.et_nic_p);
            fullName = findViewById(R.id.et_fullname_p);
            emailAddress = findViewById(R.id.et_email_p);
            phoneNo = findViewById(R.id.et_phone_no_p);
            address = findViewById(R.id.et_address_p);
            age = findViewById(R.id.et_age_p);
            edit = findViewById(R.id.btn_edt_p);
            update = findViewById(R.id.btn_update_p);
            progressBar = findViewById(R.id.pb_progress_p);

        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    public void disableEditTexts(){
        nic.setEnabled(false);
        fullName.setEnabled(false);
        emailAddress.setEnabled(false);
        phoneNo.setEnabled(false);
        address.setEnabled(false);
        age.setEnabled(false);
    }

    public void enableEditTexts(){
        nic.setEnabled(true);
        fullName.setEnabled(true);
        emailAddress.setEnabled(true);
        phoneNo.setEnabled(true);
        address.setEnabled(true);
        age.setEnabled(true);
    }

    private void buttonClick(){
        edit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                enableEditTexts();
                update.setVisibility(View.VISIBLE);
                edit.setVisibility(View.GONE);


            }
        });

        update.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                updateData();
            }
        });

    }

    public void getUserData(String cusID) {
        try
        {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[1];
                    field[0] = "cus_id";

                    //Creating array for data
                    String[] data = new String[1];
                    data[0] = cusID;

                    PutData putData = new PutData(link + "LoginRegister/fetchUserProfileData.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if (!putData.getResult().toString().trim().equals("[]")) {
                                try {
                                    //Toast.makeText(getApplicationContext(),result,Toast.LENGTH_LONG).show();
                                    loadSpecs(result);
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            } else {
                                Toast.makeText(getApplicationContext(), "No Orders!", Toast.LENGTH_SHORT).show();
                            }
                        }
                    }
                    //End Write and Read data with URL
                }
            });
        } catch(Exception ex){
            Log.e("EXCEPTION: " ,ex.toString());
        }

    }

    private void loadSpecs(String json) throws JSONException {

        JSONArray jsonArray = new JSONArray(json);
        for (int i = 0; i < jsonArray.length(); i++) {
            JSONObject obj = jsonArray.getJSONObject(i);
            fullName.setText(obj.getString("name"));
            nic.setText(obj.getString("nic"));
            address.setText(obj.getString("address"));
            phoneNo.setText(obj.getString("phone"));
            emailAddress.setText(obj.getString("email"));
            age.setText(obj.getString("age"));
        }
    }

    private void updateData(){
        try {
            final String nicVal, nameVal, emailVal, pNoVal, addressVal, ageVal;
            nicVal = String.valueOf(nic.getText());
            nameVal = String.valueOf(fullName.getText());
            emailVal = String.valueOf(emailAddress.getText());
            pNoVal = String.valueOf(phoneNo.getText());
            addressVal = String.valueOf(address.getText());
            ageVal = String.valueOf(age.getText());

            if(!nicVal.equals("") && !nameVal.equals("")  && !emailVal.equals("") && !pNoVal.equals("") && !addressVal.equals("") && !ageVal.equals("")) {

                progressBar.setVisibility(View.VISIBLE);
                Handler handler = new Handler();
                handler.post(new Runnable() {
                    @Override
                    public void run() {
                        //Starting Write and Read data with URL
                        //Creating array for parameters
                        String[] field = new String[7];
                        field[0] = "full_name";
                        field[1] = "nic";
                        field[2] = "age";
                        field[3] = "address";
                        field[4] = "phone_no";
                        field[5] = "email";
                        field[6] = "cus_id";
                        //Creating array for data
                        String[] data = new String[7];
                        data[0] = nameVal;
                        data[1] = nicVal;
                        data[2] = ageVal;
                        data[3] = addressVal;
                        data[4] = pNoVal;
                        data[5] = emailVal;
                        data[6] = id;

                        PutData putData = new PutData(link + "LoginRegister/updateProfile.php", "POST", field, data);
                        if (putData.startPut()) {
                            if (putData.onComplete()) {
                                progressBar.setVisibility(View.GONE);
                                String result = putData.getResult();
                                if(putData.getResult().toString().trim().equals("Profile Updated")){
                                    Toast.makeText(getApplicationContext(), result, Toast.LENGTH_SHORT). show();
                                    getUserData(id);
                                    disableEditTexts();
                                    update.setVisibility(View.GONE);
                                    edit.setVisibility(View.VISIBLE);
                                }

                                else{
                                    Toast.makeText(getApplicationContext(), result, Toast.LENGTH_SHORT). show();
                                }

                            }
                        }

                    }
                });
            }

            else {
                Toast.makeText(getApplicationContext(),"All Fields are Required", Toast.LENGTH_SHORT).show();
            }
        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    public void navigationDrawer(){

        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        Menu menu = navigationView.getMenu();

        navigationView.bringToFront();
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawerLayout, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawerLayout.addDrawerListener(toggle);
        toggle.syncState();

        navigationView.setNavigationItemSelectedListener(this);
    }

    @Override
    public void onBackPressed() {
        if (drawerLayout.isDrawerOpen(GravityCompat.START)) {
            drawerLayout.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem menuItem) {
        switch (menuItem.getItemId()) {
            case R.id.nav_home:
                Intent intent = new Intent(getApplicationContext(), Dashboard.class);
                intent.putExtra("email", email);
                startActivity(intent);
                break;

            case R.id.nav_cart:
                Intent intent2 = new Intent(getApplicationContext(), Cart.class);
                intent2.putExtra("id", id);
                intent2.putExtra("email", email);
                startActivity(intent2);
                break;

            case R.id.nav_orders:
                Intent intent3 = new Intent(getApplicationContext(), Orders.class);
                intent3.putExtra("id", id);
                intent3.putExtra("email", email);
                startActivity(intent3);
                break;

            case R.id.nav_account:
                Toast.makeText(getApplicationContext(), "User Profile", Toast.LENGTH_SHORT).show();

                break;

            case R.id.nav_logout:
                Intent intent4 = new Intent(getApplicationContext(), Login.class);
                startActivity(intent4);
                finish();
                break;
        }
        drawerLayout.closeDrawer(GravityCompat.START);
        return true;
    }
}

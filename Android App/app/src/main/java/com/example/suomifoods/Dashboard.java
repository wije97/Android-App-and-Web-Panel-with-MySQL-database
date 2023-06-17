package com.example.suomifoods;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.material.navigation.NavigationView;
import com.vishnusivadas.advanced_httpurlconnection.PutData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;

public class Dashboard extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener{

    DrawerLayout drawerLayout;
    NavigationView navigationView;
    Toolbar toolbar;
    String email, id, link;
    Button breakfast, lunch, dinner, desert, all;


    ListView flist;

    private ArrayList<String> fId;
    private ArrayList<String> fName;
    private ArrayList<String> fType;
    private ArrayList<String> fPrice;
    private ArrayList<String> fImage;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);

        Intent intent = getIntent();
        email = intent.getStringExtra("email");

        initialize();
        navigationDrawer();
        checkCusID(email);
        getFoods("");
        buttonClick();
        listItemClick();

    }
    private void initialize(){
        try {

            IpAddress ipA = new IpAddress();
            link = ipA.getAddress();

            drawerLayout = findViewById(R.id.drawer_layout);
            navigationView = findViewById(R.id.nav_view);
            toolbar = findViewById(R.id.toolbar);

            breakfast = (Button)findViewById(R.id.btn_brFast);
            lunch = (Button)findViewById(R.id.btn_lunch);
            dinner = (Button)findViewById(R.id.btn_dinner);
            desert = (Button)findViewById(R.id.btn_desert);
            all = (Button)findViewById(R.id.btn_all);

            flist = (ListView)findViewById(R.id.food_list);

            fId = new ArrayList<String>();
            fName = new ArrayList<String>();
            fType = new ArrayList<String>();
            fPrice = new ArrayList<String>();
            fImage = new ArrayList<String>();


        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    private void buttonClick(){
        breakfast.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getFoods("Breakfast");
            }
        });

        lunch.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getFoods("Lunch");
            }
        });

        dinner.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getFoods("Dinner");
            }
        });

        desert.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getFoods("Desert");
            }
        });

        all.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getFoods("");
            }
        });
    }

    private void getFoods(String type) {

        try
        {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[1];
                    field[0] = "columnData";

                    //Creating array for data
                    String[] data = new String[1];
                    data[0] = type;

                    PutData putData = new PutData(link + "Foods/fetchFoodDetails.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if (!putData.getResult().toString().trim().equals("")) {
                                try {
                                    //Toast.makeText(getApplicationContext(),result,Toast.LENGTH_LONG).show();
                                    loadSpecs(result);
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            } else {
                                Toast.makeText(getApplicationContext(), result, Toast.LENGTH_SHORT).show();
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

        fId.clear();
        fName.clear();
        fType.clear();
        fPrice.clear();
        fImage.clear();

        JSONArray jsonArray = new JSONArray(json);
        String[] spec = new String[jsonArray.length()];
        for (int i = 0; i < jsonArray.length(); i++) {
            JSONObject obj = jsonArray.getJSONObject(i);
            fId.add(obj.getString("id"));
            fName.add(obj.getString("name"));
            fType.add(obj.getString("type"));
            fPrice.add(obj.getString("price"));
            fImage.add(obj.getString("image"));
        }

        FoodAdapter stock_adapter = new FoodAdapter(getApplicationContext(), id, email, fId, fName, fType, fPrice,fImage, link);
        flist.setAdapter(stock_adapter);

    }

    private void checkCusID(String emailVal){
        try
        {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {

                    String[] field = new String[1];
                    field[0] = "email";

                    //Creating array for data
                    String[] data = new String[1];
                    data[0] = emailVal;

                    PutData putData = new PutData(link + "LoginRegister/fetchUserData.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if (!putData.getResult().toString().trim().equals("")) {

                                id = result;
                                //Toast.makeText(getApplicationContext(),result,Toast.LENGTH_LONG).show();

                            } else {
                                Toast.makeText(getApplicationContext(), result, Toast.LENGTH_SHORT).show();
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

    public void listItemClick(){

        flist.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                //String c_id = ((TextView) view.findViewById(R.id.tv_c_id_c)).getText().toString();
                Toast.makeText(getApplicationContext(), "www", Toast.LENGTH_SHORT).show();
            }
        });
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
                Toast.makeText(getApplicationContext(), "Dashboard", Toast.LENGTH_SHORT).show();
                break;

            case R.id.nav_cart:
                Intent intent1 = new Intent(getApplicationContext(), Cart.class);
                intent1.putExtra("id", id);
                intent1.putExtra("email", email);
                startActivity(intent1);
                break;

            case R.id.nav_orders:
                Intent intent2 = new Intent(getApplicationContext(), Orders.class);
                intent2.putExtra("id", id);
                intent2.putExtra("email", email);
                startActivity(intent2);
                break;

            case R.id.nav_account:
                Intent intent3 = new Intent(getApplicationContext(), UserProfile.class);
                intent3.putExtra("id", id);
                intent3.putExtra("email", email);
                startActivity(intent3);
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
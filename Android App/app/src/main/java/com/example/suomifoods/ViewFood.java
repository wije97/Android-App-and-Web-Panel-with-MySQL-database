package com.example.suomifoods;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.os.Handler;
import android.util.Base64;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.Toast;

import com.google.android.material.navigation.NavigationView;
import com.google.android.material.textfield.TextInputEditText;
import com.vishnusivadas.advanced_httpurlconnection.PutData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class ViewFood extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener{

    DrawerLayout drawerLayout;
    NavigationView navigationView;
    Toolbar toolbar;
    TextInputEditText fName, fType, fPrice, fDetails;
    ImageView image;

    String email, foodId, id, link;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_food);

        Intent intent = getIntent();
        email = intent.getStringExtra("email");
        foodId = intent.getStringExtra("fid");
        id = intent.getStringExtra("cid");

        initialize();
        navigationDrawer();
        disableEditTexts();
        getFoodData();
    }

    private void initialize(){
        try {

            IpAddress ipA = new IpAddress();
            link = ipA.getAddress();

            drawerLayout = findViewById(R.id.drawer_layout);
            navigationView = findViewById(R.id.nav_view);
            toolbar = findViewById(R.id.toolbar);

            fName = findViewById(R.id.et_name_f);
            fType = findViewById(R.id.et_type_f);
            fPrice = findViewById(R.id.et_price_f);
            fDetails = findViewById(R.id.et_details_f);
            image = findViewById(R.id.img_food_view);


        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    public void disableEditTexts(){
        fName.setEnabled(false);
        fType.setEnabled(false);
        fPrice.setEnabled(false);
        fDetails.setEnabled(false);
    }

    public void getFoodData() {
        try
        {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[1];
                    field[0] = "f_id";

                    //Creating array for data
                    String[] data = new String[1];
                    data[0] = foodId;

                    PutData putData = new PutData(link + "Foods/fetchFoodByID.php", "POST", field, data);
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
        String imageURL;
        JSONArray jsonArray = new JSONArray(json);
        for (int i = 0; i < jsonArray.length(); i++) {
            JSONObject obj = jsonArray.getJSONObject(i);
            fName.setText(obj.getString("name"));
            fType.setText(obj.getString("type"));
            fPrice.setText(obj.getString("price"));
            fDetails.setText(obj.getString("details"));
            imageURL = obj.getString("image");

            byte[] data = Base64.decode(imageURL, Base64.DEFAULT);
            Bitmap bmp = BitmapFactory.decodeByteArray(data, 0, data.length);

            image.setImageBitmap(bmp);
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
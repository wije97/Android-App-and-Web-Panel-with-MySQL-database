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
import android.widget.AdapterView;
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

import java.util.ArrayList;

public class Orders extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener{

    DrawerLayout drawerLayout;
    NavigationView navigationView;
    Toolbar toolbar;
    String email, cusid, link;
    ListView oList;
    EditText searchOID;

    Button pending, received, search;

    private ArrayList<String> oId;
    private ArrayList<String> oPrice;
    private ArrayList<String> oDate;
    private ArrayList<String> oStatus;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_orders);

        Intent intent = getIntent();
        cusid = intent.getStringExtra("id");
        email = intent.getStringExtra("email");

        initialize();
        navigationDrawer();
        getOrders( cusid,"");
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

            pending = (Button)findViewById(R.id.btn_pending_d);
            received = (Button)findViewById(R.id.btn_received);
            search = (Button)findViewById(R.id.btn_search);
            oList = (ListView)findViewById(R.id.order_list);
            searchOID = (EditText)findViewById(R.id.et_search);

            oId = new ArrayList<String>();
            oPrice = new ArrayList<String>();
            oDate = new ArrayList<String>();
            oStatus = new ArrayList<String>();


        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    private void buttonClick(){
        pending.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getOrders(cusid,"Pending");
            }
        });

        received.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getOrders(cusid,"Received");
            }
        });

        search.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (!searchOID.getText().toString().equals("")){
                    searchOrder(cusid, searchOID.getText().toString());
                }else{
                    Toast.makeText(getApplicationContext(),"Please Enter Order ID!",Toast.LENGTH_LONG).show();
                }
            }
        });
    }
    private void searchOrder(String cus_id, String oid) {
        try
        {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[2];
                    field[0] = "cus_id";
                    field[1] = "o_id";

                    //Creating array for data
                    String[] data = new String[2];
                    data[0] = cus_id;
                    data[1] = oid;

                    PutData putData = new PutData(link + "Foods/Order/searchOrders.php", "POST", field, data);
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
                                Toast.makeText(getApplicationContext(), "No Orders", Toast.LENGTH_SHORT).show();
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

    private void getOrders(String cus_id, String type) {
        try
        {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[2];
                    field[0] = "cus_id";
                    field[1] = "status";

                    //Creating array for data
                    String[] data = new String[2];
                    data[0] = cus_id;
                    data[1] = type;

                    PutData putData = new PutData(link + "Foods/Order/fetchOrders.php", "POST", field, data);
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
                                Toast.makeText(getApplicationContext(), "No Orders", Toast.LENGTH_SHORT).show();
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

        oId.clear();
        oPrice.clear();
        oDate.clear();
        oStatus.clear();

        JSONArray jsonArray = new JSONArray(json);
        String[] spec = new String[jsonArray.length()];
        for (int i = 0; i < jsonArray.length(); i++) {
            JSONObject obj = jsonArray.getJSONObject(i);
            oId.add(obj.getString("oid"));
            oPrice.add(obj.getString("ototal"));
            oDate.add(obj.getString("odate"));
            oStatus.add(obj.getString("ostatus"));
        }

        OrderAdapter order_adapter = new OrderAdapter(getApplicationContext(), cusid, oId, oPrice, oDate, oStatus, link);
        oList.setAdapter(order_adapter);

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

    public void listItemClick(){

        oList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

                String o_id = ((TextView) view.findViewById(R.id.tv_o_id)).getText().toString();

                Intent intent = new Intent(getApplicationContext(), ViewOrderItems.class);
                intent.putExtra("email", email);
                intent.putExtra("id",cusid);
                intent.putExtra("oid",o_id);
                startActivity(intent);
            }
        });
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
                intent1.putExtra("id", cusid);
                intent1.putExtra("email", email);
                startActivity(intent1);
                break;

            case R.id.nav_orders:
                Toast.makeText(getApplicationContext(), "Orders", Toast.LENGTH_SHORT).show();

                break;

            case R.id.nav_account:
                Intent intent3 = new Intent(getApplicationContext(), UserProfile.class);
                intent3.putExtra("id", cusid);
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
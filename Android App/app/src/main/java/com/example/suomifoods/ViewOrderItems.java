package com.example.suomifoods;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.material.navigation.NavigationView;
import com.vishnusivadas.advanced_httpurlconnection.PutData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Locale;

public class ViewOrderItems extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener{

    DrawerLayout drawerLayout;
    NavigationView navigationView;
    Toolbar toolbar;
    String id, link, email, oID;
    TextView orderID;
    Button delete;
    ListView oIList;

    private ArrayList<String> oderItemId;
    private ArrayList<String> fName;
    private ArrayList<String> fQty;
    private ArrayList<String> fPrice;
    private ArrayList<String> fImage;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_order_items);

        Intent intent = getIntent();
        email = intent.getStringExtra("email");
        id = intent.getStringExtra("id");
        oID = intent.getStringExtra("oid");

        initialize();
        navigationDrawer();
        buttonClick();

        getFoodsFromOrder(id);


    }

    private void initialize(){
        try {

            IpAddress ipA = new IpAddress();
            link = ipA.getAddress();

            drawerLayout = findViewById(R.id.drawer_layout);
            navigationView = findViewById(R.id.nav_view);
            toolbar = findViewById(R.id.toolbar);

            delete = (Button)findViewById(R.id.btn_delete);
            orderID = (TextView) findViewById(R.id.tv_order_id_v);

            orderID.setText("Order ID: " + oID);

            oIList = (ListView)findViewById(R.id.view_order_list);

            oderItemId = new ArrayList<String>();
            fName = new ArrayList<String>();
            fQty = new ArrayList<String>();
            fPrice = new ArrayList<String>();
            fImage = new ArrayList<String>();

        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    private void buttonClick(){
        delete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AlertDialog diaBox = AskOption(oID);
                diaBox.show();
            }
        });

    }

    public void getFoodsFromOrder(String cID) {
        try
        {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[1];
                    field[0] = "o_id";

                    //Creating array for data
                    String[] data = new String[1];
                    data[0] = oID;

                    PutData putData = new PutData(link + "Foods/Order/fetchFoodsInOrder.php", "POST", field, data);
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

        oderItemId.clear();
        fName.clear();
        fQty.clear();
        fPrice.clear();
        fImage.clear();

        JSONArray jsonArray = new JSONArray(json);
        String[] spec = new String[jsonArray.length()];
        for (int i = 0; i < jsonArray.length(); i++) {
            JSONObject obj = jsonArray.getJSONObject(i);
            oderItemId.add(obj.getString("o_item_id"));
            fName.add(obj.getString("name"));
            fPrice.add(obj.getString("price"));
            fQty.add(obj.getString("qty"));
            fImage.add(obj.getString("image"));
        }

        ViewOrdersAdapter view_order_adapter = new ViewOrdersAdapter(getApplicationContext(), oderItemId, fName, fQty, fPrice,fImage);
        oIList.setAdapter(view_order_adapter);
    }

    private AlertDialog AskOption(String oIDVal)
    {
        AlertDialog myQuittingDialogBox = new AlertDialog.Builder(this)
                // set message, title, and icon
                .setTitle("Are You Sure?")
                .setMessage("Do you want to Delete this Order!")
                .setIcon(R.drawable.ic_delete)

                .setPositiveButton("Yes", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int whichButton) {
                        deleteOrder(oIDVal);
                        dialog.dismiss();
                    }

                })
                .setNegativeButton("No", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {

                        dialog.dismiss();

                    }
                })
                .create();

        return myQuittingDialogBox;
    }

    private void deleteOrder(String orderIDVal){
        try {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[1];
                    field[0] = "o_id";
                    //Creating array for data
                    String[] data = new String[1];
                    data[0] = orderIDVal;

                    PutData putData = new PutData(link + "Foods/Order/deleteOrder.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if(putData.getResult().toString().trim().equals("Order Removed")){

                                Toast.makeText(getApplicationContext(),  result, Toast.LENGTH_SHORT).show();

                                Intent intent1 = new Intent(getApplicationContext(), Orders.class);
                                intent1.putExtra("id", id);
                                intent1.putExtra("email", email);
                                startActivity(intent1);
                            }
                            else{
                                Toast.makeText(getApplicationContext(),  result, Toast.LENGTH_SHORT).show();
                            }
                        }
                    }
                }
            });
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

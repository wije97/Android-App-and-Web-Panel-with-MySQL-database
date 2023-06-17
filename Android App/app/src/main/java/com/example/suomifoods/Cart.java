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
import android.widget.AdapterView;
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

public class Cart extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener{

    DrawerLayout drawerLayout;
    NavigationView navigationView;
    Toolbar toolbar;
    String id, link, email, orderID;
    TextView totalPrice;
    Button order;
    double total;
    ListView clist;

    private ArrayList<String> cId;
    private ArrayList<String> fName;
    private ArrayList<String> fQty;
    private ArrayList<String> fPrice;
    private ArrayList<String> fImage;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cart);

        Intent intent = getIntent();
        id = intent.getStringExtra("id");
        email = intent.getStringExtra("email");

        initialize();
        navigationDrawer();
        buttonClick();
        getFoodsFromCart(id, "1");
        listItemClick();

    }

    private void initialize(){
        try {

            IpAddress ipA = new IpAddress();
            link = ipA.getAddress();

            drawerLayout = findViewById(R.id.drawer_layout);
            navigationView = findViewById(R.id.nav_view);
            toolbar = findViewById(R.id.toolbar);

            order = (Button)findViewById(R.id.btn_order);
            totalPrice = (TextView) findViewById(R.id.tv_total);

            clist = (ListView)findViewById(R.id.cart_list);

            cId = new ArrayList<String>();
            fName = new ArrayList<String>();
            fQty = new ArrayList<String>();
            fPrice = new ArrayList<String>();
            fImage = new ArrayList<String>();

        }catch (Exception e){
            Toast.makeText(getApplicationContext(), (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }

    private void buttonClick(){
        order.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                insertOrder();
            }
        });

    }

    public void getFoodsFromCart(String cID, String gtype) {
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
                    data[0] = cID;

                    PutData putData = new PutData(link + "Foods/Cart/fetchFoodsFromCart.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if (!putData.getResult().toString().trim().equals("[]")) {
                                try {
                                    //Toast.makeText(getApplicationContext(),result,Toast.LENGTH_LONG).show();
                                    if (gtype.equals("1")){
                                        loadSpecs(result, "1");
                                    }else if (gtype.equals("2")){
                                        loadSpecs(result, "2");
                                    }
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            } else {
                                Toast.makeText(getApplicationContext(), "No Foods in Cart!", Toast.LENGTH_SHORT).show();
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

    private void loadSpecs(String json, String type) throws JSONException {

        if (type.equals("1")){
            cId.clear();
            fName.clear();
            fQty.clear();
            fPrice.clear();
            fImage.clear();

            JSONArray jsonArray = new JSONArray(json);
            String[] spec = new String[jsonArray.length()];
            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject obj = jsonArray.getJSONObject(i);
                cId.add(obj.getString("cid"));
                fName.add(obj.getString("name"));
                fPrice.add(obj.getString("price"));
                fQty.add(obj.getString("qty"));
                fImage.add(obj.getString("image"));

                //double subTotal = Double.parseDouble(String.valueOf(obj.getString("price"))) * Integer.parseInt(String.valueOf(obj.getString("qty")));
                //total += subTotal;
                //totalPrice.setText(String.valueOf(total));
            }

            int size = fPrice.size();
            for (int i = 0; i< size; i++){
                double subTotal = Double.parseDouble(String.valueOf(fPrice.get(i))) * Integer.parseInt(String.valueOf(fQty.get(i)));
                total += subTotal;
                totalPrice.setText(String.valueOf(total));
            }

            CartAdapter cart_adapter = new CartAdapter(getApplicationContext(), id, email, cId, fName, fQty, fPrice,fImage, link);
            clist.setAdapter(cart_adapter);

            //double total = cart_adapter.getTotal();
        }else if (type.equals("2")){

            JSONArray jsonArray = new JSONArray(json);
            String[] spec = new String[jsonArray.length()];
            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject obj = jsonArray.getJSONObject(i);

                String fID, fQTY;
                fID = obj.getString("fid");
                fQTY = obj.getString("qty");

                insertOrderFoodItems(fID,fQTY, orderID);

            }
        }


    }

    public void insertOrder(){
        try
        {
            String date = new SimpleDateFormat("yyyy-MM-dd", Locale.getDefault()).format(new Date());

            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[3];
                    field[0] = "cus_id";
                    field[1] = "o_total";
                    field[2] = "date";

                    //Creating array for data
                    String[] data = new String[3];
                    data[0] = id;
                    data[1] = totalPrice.getText().toString();
                    data[2] = date;

                    PutData putData = new PutData(link + "Foods/Order/addOrder.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if (!putData.getResult().toString().trim().equals("[]")) {
                                orderID = result;
                                //Toast.makeText(getApplicationContext(),orderID,Toast.LENGTH_LONG).show();
                                getFoodsFromCart(id, "2");
                            } else {
                                Toast.makeText(getApplicationContext(), "No Foods in Cart!", Toast.LENGTH_SHORT).show();
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

    public void insertOrderFoodItems(String f_id, String f_qty, String o_id){
        try
        {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[3];
                    field[0] = "f_id";
                    field[1] = "f_qty";
                    field[2] = "o_id";

                    //Creating array for data
                    String[] data = new String[3];
                    data[0] = f_id;
                    data[1] = f_qty;
                    data[2] = o_id;

                    PutData putData = new PutData(link + "Foods/Order/addOrderItems.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if (!putData.getResult().toString().trim().equals("[]")) {

                                Toast.makeText(getApplicationContext(),result,Toast.LENGTH_LONG).show();
                                removeFromCart(id);

                            } else {
                                Toast.makeText(getApplicationContext(), "No Foods in Cart!", Toast.LENGTH_SHORT).show();
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

    private void removeFromCart(String cusIDVal){
        try {
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
                    data[0] = cusIDVal;

                    PutData putData = new PutData(link + "Foods/Cart/deleteFromCartByUser.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if(putData.getResult().toString().trim().equals("Removed from Cart")){
                                Intent intent1 = new Intent(getApplicationContext(), Cart.class);
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

    public void listItemClick(){

        clist.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

                String c_id = ((TextView) view.findViewById(R.id.tv_c_id_c)).getText().toString();

                AlertDialog diaBox = AskOption(c_id);
                diaBox.show();

            }
        });

    }

    private AlertDialog AskOption(String cartIDVal)
    {
        AlertDialog myQuittingDialogBox = new AlertDialog.Builder(this)
                // set message, title, and icon
                .setTitle("Are You Sure?")
                .setMessage("Do you want to Remove this Item from Cart!")
                .setIcon(R.drawable.ic_delete)

                .setPositiveButton("Yes", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int whichButton) {
                        cartItemRemove(cartIDVal);
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

    private void cartItemRemove(String cartID){
        try {
            Handler handler = new Handler();
            handler.post(new Runnable() {
                @Override
                public void run() {
                    //Starting Write and Read data with URL
                    //Creating array for parameters
                    String[] field = new String[1];
                    field[0] = "c_id";
                    //Creating array for data
                    String[] data = new String[1];
                    data[0] = cartID;

                    PutData putData = new PutData(link + "Foods/Cart/deleteFromCart.php", "POST", field, data);
                    if (putData.startPut()) {
                        if (putData.onComplete()) {
                            String result = putData.getResult();
                            if(putData.getResult().toString().trim().equals("Removed from Cart")){
                                Toast.makeText(getApplicationContext(),  result, Toast.LENGTH_SHORT).show();
                                Intent intent1 = new Intent(getApplicationContext(), Cart.class);
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
                Toast.makeText(getApplicationContext(), "Cart", Toast.LENGTH_SHORT).show();
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

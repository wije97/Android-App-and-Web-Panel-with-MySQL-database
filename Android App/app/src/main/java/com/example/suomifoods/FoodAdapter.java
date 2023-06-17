package com.example.suomifoods;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Handler;
import android.util.Base64;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.PopupWindow;
import android.widget.TextView;
import android.widget.Toast;

import com.vishnusivadas.advanced_httpurlconnection.PutData;

import java.util.ArrayList;

public class FoodAdapter extends BaseAdapter {

    private Context mContext;
    private String link;
    private String cus_id, email;

    private ArrayList<String> f_id = new ArrayList<String>();
    private ArrayList<String> f_name = new ArrayList<String>();
    private ArrayList<String> f_type = new ArrayList<String>();
    private ArrayList<String> f_price = new ArrayList<String>();
    private ArrayList<String> f_img = new ArrayList<String>();

    public FoodAdapter(Context context, String cus_id, String email, ArrayList<String> f_id, ArrayList<String> f_name, ArrayList<String> f_type, ArrayList<String> f_price, ArrayList<String> f_img, String link
    ) {
        this.mContext = context;
        this.cus_id=cus_id;
        this.email=email;
        this.f_id = f_id;
        this.f_name = f_name;
        this.f_type = f_type;
        this.f_price = f_price;
        this.f_img = f_img;
        this.link=link;
    }

    @Override
    public int getCount() {
        return f_id.size();
    }

    @Override
    public Object getItem(int position) {
        return null;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @SuppressLint("SetTextI18n")
    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        final FoodAdapter.viewHolder holder;
        LayoutInflater layoutInflater;
        if (convertView == null) {
            layoutInflater = (LayoutInflater) mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = layoutInflater.inflate(R.layout.food_list, null);
            holder = new FoodAdapter.viewHolder();
            holder.tv_id = (TextView) convertView.findViewById(R.id.tv_f_id);
            holder.tv_name = (TextView) convertView.findViewById(R.id.tv_f_name);
            holder.tv_type = (TextView) convertView.findViewById(R.id.tv_f_type);
            holder.tv_price = (TextView) convertView.findViewById(R.id.tv_f_price);
            holder.iv_img = (ImageView) convertView.findViewById(R.id.iv_image);
            holder.foodQty = (EditText) convertView.findViewById(R.id.et_f_qty);
            holder.addToCart = (Button)convertView.findViewById(R.id.btn_add_to_cart);
            convertView.setTag(holder);
        } else {
            holder = (FoodAdapter.viewHolder) convertView.getTag();
        }

        holder.tv_id.setText(f_id.get(position));
        holder.tv_name.setText(f_name.get(position));
        holder.tv_type.setText(f_type.get(position));
        holder.tv_price.setText("Rs: " + f_price.get(position));

        byte[] data = Base64.decode(String.valueOf(f_img.get(position)), Base64.DEFAULT);
        Bitmap bmp = BitmapFactory.decodeByteArray(data, 0, data.length);
        holder.iv_img.setImageBitmap(bmp);

        holder.addToCart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String qty = holder.foodQty.getText().toString();
                String fID = holder.tv_id.getText().toString();

                if (qty.equals("0")){
                    Toast.makeText(mContext,  "Please Enter Valid Quantity!", Toast.LENGTH_SHORT).show();
                }else if (qty.equals("")){
                    Toast.makeText(mContext,  "Please Enter Valid Quantity!", Toast.LENGTH_SHORT).show();
                }else{
                    insertCart(qty,fID);
                    holder.foodQty.setText("1");
                }

            }
        });

        convertView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Intent intent=new Intent(mContext.getApplicationContext(), ViewFood.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_MULTIPLE_TASK);
                intent.putExtra("email", email);
                intent.putExtra("fid", f_id.get(position));
                intent.putExtra("cid", cus_id);
                mContext.getApplicationContext().startActivity(intent);
            }
        });

        return convertView;

    }

    public class viewHolder {
        TextView tv_name;
        TextView tv_type;
        TextView tv_price;
        TextView tv_id;
        ImageView iv_img;
        EditText foodQty;
        Button addToCart;
    }

    private void insertCart(String qtyVal, String foodVal){

        try {
                Handler handler = new Handler();
                handler.post(new Runnable() {
                    @Override
                    public void run() {
                        //Starting Write and Read data with URL
                        //Creating array for parameters
                        String[] field = new String[3];
                        field[0] = "cus_id";
                        field[1] = "f_id";
                        field[2] = "f_qty";
                        //Creating array for data
                        String[] data = new String[3];
                        data[0] = cus_id;
                        data[1] = foodVal;
                        data[2] = qtyVal;

                        PutData putData = new PutData(link + "Foods/Cart/addToCart.php", "POST", field, data);
                        if (putData.startPut()) {
                            if (putData.onComplete()) {
                                String result = putData.getResult();
                                if(putData.getResult().toString().trim().equals("Successfully Added to Cart")){
                                    Toast.makeText(mContext,  result, Toast.LENGTH_SHORT).show();
                                }
                                else{
                                    Toast.makeText(mContext,  result, Toast.LENGTH_SHORT).show();
                                }
                            }
                        }
                    }
                });
        }catch (Exception e){
            Toast.makeText(mContext, (CharSequence) e, Toast.LENGTH_SHORT).show();
        }
    }
}

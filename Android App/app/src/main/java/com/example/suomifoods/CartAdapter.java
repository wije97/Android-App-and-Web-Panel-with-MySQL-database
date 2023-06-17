package com.example.suomifoods;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Handler;
import android.util.Base64;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.vishnusivadas.advanced_httpurlconnection.PutData;

import java.util.ArrayList;

public class CartAdapter extends BaseAdapter {

    private Context mContext;
    private String cus_id, link, email;

    private ArrayList<String> c_id = new ArrayList<String>();
    private ArrayList<String> f_name = new ArrayList<String>();
    private ArrayList<String> f_qty = new ArrayList<String>();
    private ArrayList<String> f_price = new ArrayList<String>();
    private ArrayList<String> f_img = new ArrayList<String>();

    public CartAdapter(Context context, String cus_id, String email, ArrayList<String> c_id, ArrayList<String> f_name, ArrayList<String> f_qty, ArrayList<String> f_price, ArrayList<String> f_img, String link
    ) {
        this.mContext = context;
        this.cus_id = cus_id;
        this.email = email;
        this.c_id = c_id;
        this.f_name = f_name;
        this.f_qty = f_qty;
        this.f_price = f_price;
        this.f_img = f_img;
        this.link=link;
    }

    @Override
    public int getCount() {
        return c_id.size();
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
        final CartAdapter.viewHolder holder;
        LayoutInflater layoutInflater;
        if (convertView == null) {
            layoutInflater = (LayoutInflater) mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = layoutInflater.inflate(R.layout.cart_list, null);
            holder = new CartAdapter.viewHolder();
            holder.tv_cid = (TextView) convertView.findViewById(R.id.tv_c_id_c);
            holder.tv_name = (TextView) convertView.findViewById(R.id.tv_f_name_c);
            holder.tv_price = (TextView) convertView.findViewById(R.id.tv_f_price_c);
            holder.iv_img = (ImageView) convertView.findViewById(R.id.iv_image_c);
            holder.tv_qty = (TextView) convertView.findViewById(R.id.tv_qty_c);
            //holder.remove = (Button)convertView.findViewById(R.id.btn_remove_c);
            convertView.setTag(holder);
        } else {
            holder = (CartAdapter.viewHolder) convertView.getTag();
        }

        holder.tv_cid.setText(c_id.get(position));
        holder.tv_name.setText(f_name.get(position));
        holder.tv_qty.setText(f_qty.get(position));
        holder.tv_price.setText("Rs: " + f_price.get(position));

        byte[] data = Base64.decode(String.valueOf(f_img.get(position)), Base64.DEFAULT);
        Bitmap bmp = BitmapFactory.decodeByteArray(data, 0, data.length);
        holder.iv_img.setImageBitmap(bmp);

        /*holder.remove.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                String cID = holder.tv_cid.getText().toString();
                removeFromCart(cID);
                c_id.remove(c_id.get(position));
                f_name.remove(f_name.get(position));
                f_price.remove(f_price.get(position));
                f_qty.remove(f_qty.get(position));
                f_img.remove(f_img.get(position));
                notifyDataSetChanged();
            }
        });*/

        return convertView;

    }

    public class viewHolder {
        TextView tv_name;
        TextView tv_qty;
        TextView tv_price;
        TextView tv_cid;
        ImageView iv_img;
        //Button remove;
    }

}


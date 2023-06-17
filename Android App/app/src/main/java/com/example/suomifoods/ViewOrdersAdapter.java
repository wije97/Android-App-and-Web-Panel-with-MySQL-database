package com.example.suomifoods;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Base64;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

public class ViewOrdersAdapter extends BaseAdapter {

    private Context mContext;

    private ArrayList<String> o_id = new ArrayList<String>();
    private ArrayList<String> f_name = new ArrayList<String>();
    private ArrayList<String> f_qty = new ArrayList<String>();
    private ArrayList<String> f_price = new ArrayList<String>();
    private ArrayList<String> f_img = new ArrayList<String>();

    public ViewOrdersAdapter(Context context, ArrayList<String> o_id, ArrayList<String> f_name, ArrayList<String> f_qty, ArrayList<String> f_price, ArrayList<String> f_img
    ) {
        this.mContext = context;
        this.o_id = o_id;
        this.f_name = f_name;
        this.f_qty = f_qty;
        this.f_price = f_price;
        this.f_img = f_img;
    }

    @Override
    public int getCount() {
        return o_id.size();
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
        final ViewOrdersAdapter.viewHolder holder;
        LayoutInflater layoutInflater;
        if (convertView == null) {
            layoutInflater = (LayoutInflater) mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = layoutInflater.inflate(R.layout.view_order_list, null);
            holder = new ViewOrdersAdapter.viewHolder();
            holder.tv_oid = (TextView) convertView.findViewById(R.id.tv_oi_id);
            holder.tv_name = (TextView) convertView.findViewById(R.id.tv_oi_name);
            holder.tv_price = (TextView) convertView.findViewById(R.id.tv_oi_price);
            holder.iv_img = (ImageView) convertView.findViewById(R.id.iv_oi_image);
            holder.tv_qty = (TextView) convertView.findViewById(R.id.tv_oi_qty);
            convertView.setTag(holder);
        } else {
            holder = (ViewOrdersAdapter.viewHolder) convertView.getTag();
        }

        holder.tv_oid.setText(o_id.get(position));
        holder.tv_name.setText(f_name.get(position));
        holder.tv_qty.setText(f_qty.get(position));
        holder.tv_price.setText("Rs: " + f_price.get(position));

        byte[] data = Base64.decode(String.valueOf(f_img.get(position)), Base64.DEFAULT);
        Bitmap bmp = BitmapFactory.decodeByteArray(data, 0, data.length);
        holder.iv_img.setImageBitmap(bmp);

        return convertView;

    }

    public class viewHolder {
        TextView tv_name;
        TextView tv_qty;
        TextView tv_price;
        TextView tv_oid;
        ImageView iv_img;
    }

}


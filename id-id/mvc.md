---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='architecture'></a>

# Arsitektur MVC

Phalcon offers the object-oriented classes, necessary to implement the Model, View, Controller architecture (often referred to as [MVC](https://en.wikipedia.org/wiki/Model–view–controller)) in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* Isolasi dari logika bisnis dari antarmuka pengguna dan lapisan database
* Penyusun ini jelas dimana jenisnya berbeda dari kode milik untuk pemeliharaan lebih mudah

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in C language, offering a high performance approach of this pattern in a PHP based application.

<a name='models'></a>

## Model

Sebuah model mewakili informasi (data) aplikasi dan aturan untuk memanipulasi data tersebut. Model terutama digunakan untuk mengelola aturan interaksi dengan tabel database yang sesuai. Dalam kebanyakan kasus, setiap tabel dalam database anda akan sesuai dengan satu model dalam aplikasi anda. Sebagian besar logika bisnis aplikasi anda akan terkonsentrasi pada model. [Learn more](/4.0/en/models)

<a name='views'></a>

## Lihat

Tampilan menyajikan antarmuka pengguna dari aplikasi anda. Tampilannya sering kali berupa file HTML dengan kode PHP melekat yang melakukan tugas berkaitan hanya dengan penyajian data. Tampilan melakukan pekerjaan memberikan data ke browser web atau alat lain yang digunakan untuk mengajukan permintaan dari aplikasi anda. [Learn more](/4.0/en/views)

<a name='controllers'></a>

## Pengawas

The controllers provide the 'flow' between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [Learn more](/4.0/en/controllers)
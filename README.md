#Sifo Plugin Installer

Simple composer plugin for installing sifo components.

##Usage

Just add this package to your _require_ list and define your package _type_.

    "type": "sifo-library",
    "require": {
        "kpacha/sifo-plugin-installer": "~0.1"
    }

##Allowed types

Currently, this plugin supports two kind of packages:

* Instances: "sifo-instance"
* Libraries: "sifo-library"

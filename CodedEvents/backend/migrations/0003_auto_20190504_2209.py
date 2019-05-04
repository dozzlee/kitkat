# Generated by Django 2.2 on 2019-05-04 22:09

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('backend', '0002_auto_20190501_0618'),
    ]

    operations = [
        migrations.AddField(
            model_name='address',
            name='city',
            field=models.CharField(max_length=100, null=True),
        ),
        migrations.AddField(
            model_name='address',
            name='code',
            field=models.CharField(max_length=30, null=True),
        ),
        migrations.AddField(
            model_name='address',
            name='province',
            field=models.CharField(max_length=30, null=True),
        ),
        migrations.AddField(
            model_name='address',
            name='street',
            field=models.CharField(max_length=255, null=True),
        ),
        migrations.AlterField(
            model_name='booking',
            name='user',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='backend.Profile'),
        ),
    ]
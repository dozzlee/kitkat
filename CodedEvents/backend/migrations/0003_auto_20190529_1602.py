# Generated by Django 2.2.1 on 2019-05-29 16:02

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('backend', '0002_event_tickets_available'),
    ]

    operations = [
        migrations.AddField(
            model_name='event',
            name='check_ins',
            field=models.IntegerField(default=None),
        ),
        migrations.AddField(
            model_name='event',
            name='end_time',
            field=models.DateTimeField(default=None),
        ),
        migrations.AddField(
            model_name='event',
            name='registration_opens',
            field=models.DateTimeField(default=None),
        ),
        migrations.AddField(
            model_name='event',
            name='start_time',
            field=models.DateTimeField(default=None),
        ),
        migrations.AddField(
            model_name='ticket',
            name='price',
            field=models.FloatField(default=None),
        ),
        migrations.AddField(
            model_name='ticket',
            name='quantity',
            field=models.IntegerField(default=None),
        ),
        migrations.AddField(
            model_name='ticket',
            name='shut_off_time',
            field=models.DateTimeField(default=None),
        ),
    ]

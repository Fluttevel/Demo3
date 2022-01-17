# Generated by Django 3.0.6 on 2020-06-05 18:16

from django.conf import settings
from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        migrations.swappable_dependency(settings.AUTH_USER_MODEL),
        ('AppUtilities', '0011_auto_20200605_2040'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='lastcounterreading',
            name='login',
        ),
        migrations.AddField(
            model_name='lastcounterreading',
            name='id_reading',
            field=models.AutoField(default=1, primary_key=True, serialize=False, verbose_name='ID-Последнего показания'),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='lastcounterreading',
            name='username',
            field=models.ForeignKey(default=1, on_delete=django.db.models.deletion.CASCADE, to=settings.AUTH_USER_MODEL, verbose_name='Пользователь'),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='services',
            name='username',
            field=models.OneToOneField(default=2, on_delete=django.db.models.deletion.CASCADE, to=settings.AUTH_USER_MODEL, verbose_name='Пользователь'),
            preserve_default=False,
        ),
    ]
import datetime
from django.core.exceptions import ValidationError
from django.utils.translation import ugettext_lazy as _
from backend.models import *
from django import forms
from django.shortcuts import get_object_or_404

class EditEventForm(forms.ModelForm):
    name = forms.CharField(max_length=30)
    desc = forms.CharField(max_length=100)
    tickets_available = forms.IntegerField()
    organizers = forms.ModelMultipleChoiceField(queryset=Profile.objects.all())

    class Meta:
        model = Event
        fields = ['name', 'desc', 'tickets_available', 'organizers', 'end_time']

class AddEventForm(forms.ModelForm):
    name = forms.CharField(max_length=30)
    desc = forms.CharField(max_length=100)
    tickets_available = forms.IntegerField()
    organizers = forms.ModelMultipleChoiceField(queryset=Profile.objects.all())
    address = forms.ModelMultipleChoiceField(queryset=Address.objects.all())
    categories = forms.ModelMultipleChoiceField(queryset=Category.objects.all())
    check_ins = models.IntegerField(default = None)
    start_time = models.DateTimeField(default  = None, blank = False, null = False)
    end_time = models.DateTimeField(default = None, blank = False, null = False)
    registration_opens = models.DateTimeField(default = None)

    class Meta:
        model = Event
        fields = ['name', 'desc', 'tickets_available', 'organizers', 'end_time', 'start_time', 'check_ins', 'registration_opens', 'categories', 'address']
        exclude = ['address', 'categories', 'organizers']

    def clean_address(self):
        address_id = self.cleaned_data.get('address')

        try:
            self.address = Address.objects.get(pk=self.data['address'])
        except Address.DoesNotExist:
            raise forms.ValidationError('Sorry, that address id is not valid.')

        return address_id
    
    def clean_categories(self):
        categories_id = self.cleaned_data.get('categories')
        try:
            self.categories = Category.objects.get(pk=self.data['categories'])
        except Category.DoesNotExist:
            raise forms.ValidationError('Sorry, that category id is not valid.')

        return categories_id

    def clean_organizers(self):
        organizers_id = self.cleaned_data.get('organizers')
        try:
            self.organizers = Profile.objects.get(pk=self.data['organizers'])
        except Profile.DoesNotExist:
            raise forms.ValidationError('Sorry, that profile id is not valid.')

        return organizers_id

    def save(self, commit=True):
        instance = super(AddEventForm, self).save(commit=False)

        instance.address = self.address
        instance.save()
        instance.categories.add(self.categories)
        instance.organizers.add(self.organizers)
        if commit:
            instance.save()
        return instance
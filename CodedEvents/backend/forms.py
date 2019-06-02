import datetime
from django.core.exceptions import ValidationError
from django.utils.translation import ugettext_lazy as _
from backend.models import *
from django.forms.models import fields_for_model,model_to_dict
from django import forms
from django.forms import formset_factory, BaseFormSet
from django.shortcuts import get_object_or_404

class EventBaseForm(forms.ModelForm):
    name = forms.CharField(max_length=30, required=False)
    desc = forms.CharField(max_length=100, required=False)
    tickets_available = forms.IntegerField(required=False)
    organizers = forms.ModelMultipleChoiceField(queryset=Profile.objects.all(), required=False)

    class Meta:
        model = Event
        fields = ('name', 'desc', 'tickets_available', 'organizers')

class EditEventForm(EventBaseForm):
    ticket_desc = forms.CharField(max_length=30, required=False)
    quantity = forms.IntegerField(required=False)
    price = forms.FloatField(required=False)
    status = forms.CharField(max_length=30, required=False)
    shut_off_time = forms.DateTimeField(required=False)

    class Meta(EventBaseForm.Meta):
        fields = EventBaseForm.Meta.fields + ('ticket_desc', 'price','quantity', 'status', 'shut_off_time')
    
    def save(self, commit=True, ticket=None):
        instance = super(EditEventForm, self).save(commit=False)

        # Check if ticket instance was passed in arguments
        if ticket == None:
            ticket = Ticket()

        # Check if all values filled and save to ticket instance
        setattr(ticket, 'ticket_desc', self.cleaned_data['ticket_desc'])
        setattr(ticket, 'quantity', self.cleaned_data['quantity'])
        setattr(ticket, 'price', self.cleaned_data['price'])
        setattr(ticket, 'status', self.cleaned_data['status'])
        setattr(ticket, 'shut_off_time', self.cleaned_data['shut_off_time'])
        setattr(ticket, 'event_id', instance.id)

        ticket.save()
        # if commit:
        #     instance.save()
        return instance

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

class BuyTicketForm(forms.ModelForm):

    class Meta:
        model = CartInstance
        fields = ['ticket', 'quantity', 'created_at', 'updated_at']
        exclude = ['cart']

    def __init__(self, *args, **kwargs):
        super(BuyTicketForm, self).__init__(*args, **kwargs)

        for i in list(self.fields.keys()):
            v = self.fields[i]
            self.fields["{}_{}".format(v, i)] = forms.CharField()

class BaseTicketFormSet(BaseFormSet):
    def clean(self):
        """Checks that no two articles have the same title."""
        if any(self.errors):
            # Don't bother validating the formset unless each form is valid on its own
            return
        titles = []
        for form in self.forms:
            if self.can_delete and self._should_delete_form(form):
                continue
            title = form.cleaned_data.get('ticket')
            if title in titles:
                raise forms.ValidationError("Articles in a set must have distinct titles.")
            titles.append(title)

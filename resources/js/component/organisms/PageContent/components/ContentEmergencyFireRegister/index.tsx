import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentEmergencyFireRegisterProps } from '../../../../../props/props';
import Button from '../../../../atoms/Buttons/Button';
import LabelInput from '../../../../atoms/Form/LabelInput';
import LabelInputDate from '../../../../atoms/Form/LabelInputDate';
import LabelInputTime from '../../../../atoms/Form/LabelInputTime';
import LabelTextarea from '../../../../atoms/Form/LabelTextarea';
import RowHeadline from '../../../../atoms/RowHeadline';
import { getCookie, getCSRFToken } from '../../../../component_helper';
import FireDepartmentFireRegister from '../../../../molecules/FireDepartmentFireRegister';
import FireRegisterDeclarationOfConsent from '../../../../molecules/FireRegisterDeclarationOfConsent';
import PrivacyNotice from '../../../../molecules/PrivacyNotice';
import SaveInfoError from '../../../../molecules/SaveInfoError';
import Spacer from '../../../../molecules/Spacer';
import ErrorBoundary from '../../../errorboundary';

const ContentEmergencyFireRegister: React.FC<
  React.PropsWithChildren<ContentEmergencyFireRegisterProps>
> = (props: ContentEmergencyFireRegisterProps): JSX.Element => {
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const [getValueSurname, setValueSurname] = useState<any>('');
  const [getValueFirstname, setValueFirstname] = useState<any>('');
  const [getValueStreet, setValueStreet] = useState<any>('');
  const [getValueZipCode, setValueZipCode] = useState<any>('');
  const [getValueCity, setValueCity] = useState<any>('');
  const [getValuePhone, setValuePhone] = useState<any>('');
  const [getValueMobilePhone, setValueMobilePhone] = useState<any>('');
  const [getValueEmail, setValueEmail] = useState<any>('');
  const [getValueFireDate, setValueFireDate] = useState<any>('');
  const [getValueFireTime, setValueFireTime] = useState<any>('');
  const [getValueFireStreet, setValueFireStreet] = useState<any>('');
  const [getValueFireZipCode, setValueFireZipCode] = useState<any>('');
  const [getValueFireCity, setValueFireCity] = useState<any>('');
  const [getValueFireMessage, setValueFireMessage] = useState<any>('');
  const [getValueFireRegisterDeclaration, setValueFireRegisterDeclaration] =
    useState<boolean>(false);
  const [getValuePrivacyNotice, setValuePrivacyNotice] = useState<boolean>(false);
  const [getFormValid, setFormValid] = useState<boolean>(false);
  const [getFormError, setFormErrors] = useState<any>({
    email: false,
    firstname: false,
    surname: false,
    street: false,
    zipcode: false,
    city: false,
    phone: false,
    mobilephone: false,
    firedate: false,
    firetime: false,
    firestreet: false,
    firezipcode: false,
    firecity: false,
    firemessage: false,
    privatenotice: false,
    registerdeclaration: false,
  });
  const [getSurnameValid, setSurnameValid] = useState<boolean>(false);
  const [getFirstnameValid, setFirstnameValid] = useState<boolean>(false);
  const [getStreetValid, setStreetValid] = useState<boolean>(false);
  const [getZipCodeValid, setZipCodeValid] = useState<boolean>(false);
  const [getCityValid, setCityValid] = useState<boolean>(false);
  const [getPhoneValid, setPhoneValid] = useState<boolean>(false);
  const [getMobilePhoneValid, setMobilePhoneValid] = useState<boolean>(false);
  const [getEmailValid, setEmailValid] = useState<boolean>(false);
  const [getFireDateValid, setFireDateValid] = useState<boolean>(false);
  const [getFireTimeValid, setFireTimeValid] = useState<boolean>(false);
  const [getFireStreetValid, setFireStreetValid] = useState<boolean>(false);
  const [getFireZipCodeValid, setFireZipCodeValid] = useState<boolean>(false);
  const [getFireCityValid, setFireCityValid] = useState<boolean>(false);
  const [getFireMessageValid, setFireMessageValid] = useState<boolean>(false);
  const [getFireRegisterDeclarationValid, setFireRegisterDeclarationValid] =
    useState<boolean>(false);
  const [getPrivacyNoticeValid, setPrivacyNoticeValid] = useState<boolean>(false);

  function CheckResponse(data) {
    if (data.success === true) {
      setResponseText('Erfolgreich versendet!');
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  if (typeof props.data === 'undefined') {
    return <></>;
  }

  function validateField(fieldName, value) {
    const valid = false;

    switch (fieldName) {
      case 'email':
        setEmailValid(value.match(/^([\w.%+-]+)@([\w-]+\.)+([\w]{2,})$/i));
        setFormErrors(datas => ({ ...datas, email: getEmailValid ? '' : ' is invalid' }));
        break;
      case 'surname':
        setSurnameValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, surname: getSurnameValid ? '' : ' is too short' }));
        break;
      case 'firstname':
        setFirstnameValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, firstname: getFirstnameValid ? '' : ' is too short' }));
        break;
      case 'street':
        setStreetValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, street: getStreetValid ? '' : ' is too short' }));
        break;
      case 'zipcode':
        setZipCodeValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, zipcode: getZipCodeValid ? '' : ' is too short' }));
        break;
      case 'city':
        setCityValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, city: getCityValid ? '' : ' is too short' }));
        break;
      case 'phone':
        setPhoneValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, phone: getPhoneValid ? '' : ' is too short' }));
        break;
      case 'mobilephone':
        setMobilePhoneValid(value.length >= 6);
        setFormErrors(datas => ({
          ...datas,
          mobilephone: getMobilePhoneValid ? '' : ' is too short',
        }));
        break;
      case 'firedate':
        setFireDateValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, firedate: getFireDateValid ? '' : ' is too short' }));
        break;
      case 'firetime':
        setFireTimeValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, firetime: getFireTimeValid ? '' : ' is too short' }));
        break;
      case 'firestreet':
        setFireStreetValid(value.length >= 6);
        setFormErrors(datas => ({
          ...datas,
          firestreet: getFireStreetValid ? '' : ' is too short',
        }));
        break;
      case 'firezipcode':
        setFireZipCodeValid(value.length >= 6);
        setFormErrors(datas => ({
          ...datas,
          firezipcode: getFireZipCodeValid ? '' : ' is too short',
        }));
        break;
      case 'firecity':
        setFireCityValid(value.length >= 6);
        setFormErrors(datas => ({ ...datas, firecity: getFireCityValid ? '' : ' is too short' }));
        break;
      case 'firemessage':
        setFireMessageValid(value.length >= 6);
        setFormErrors(datas => ({
          ...datas,
          firemessage: getFireMessageValid ? '' : ' is too short',
        }));
        break;
      case 'privatenotice':
        setPrivacyNoticeValid(value.length >= 6);
        setFormErrors(datas => ({
          ...datas,
          privatenotice: getPrivacyNoticeValid ? '' : ' is too short',
        }));
        break;
      case 'registerdeclaration':
        setFireRegisterDeclarationValid(value.length >= 6);
        setFormErrors(datas => ({
          ...datas,
          registerdeclaration: getFireRegisterDeclarationValid ? '' : ' is too short',
        }));
        break;
      default:
        break;
    }
    setFormValid(
      getEmailValid &&
        getSurnameValid &&
        getFirstnameValid &&
        getStreetValid &&
        getZipCodeValid &&
        getCityValid &&
        getMobilePhoneValid &&
        getEmailValid &&
        getFireDateValid &&
        getFireTimeValid
    );
  }

  const valueSurname = (name: string | number): void => {
    setValueSurname(name);
    validateField('surname', name);
  };
  const valueFirstname = (name: string | number): void => {
    setValueFirstname(name);
    validateField('firstname', name);
  };
  const valueStreet = (name: string | number): void => {
    setValueStreet(name);
    validateField('street', name);
  };
  const valueZipCode = (name: string | number): void => {
    setValueZipCode(name);
    validateField('zipcode', name);
  };
  const valueCity = (name: string | number): void => {
    setValueCity(name);
    validateField('city', name);
  };
  const valuePhone = (name: string | number): void => {
    setValuePhone(name);
    validateField('phone', name);
  };
  const valueMobilePhone = (name: string | number): void => {
    setValueMobilePhone(name);
    validateField('mobilephone', name);
  };
  const valueEmail = (name: string | number): void => {
    setValueEmail(name);
    validateField('email', name);
  };
  const valueFireDate = (name: string | number): void => {
    setValueFireDate(name);
    validateField('firedate', name);
  };
  const valueFireTime = (name: string | number): void => {
    setValueFireTime(name);
    validateField('firetime', name);
  };
  const valueFireStreet = (name: string | number): void => {
    setValueFireStreet(name);
    validateField('firestreet', name);
  };
  const valueFireZipCode = (name: string | number): void => {
    setValueFireZipCode(name);
    validateField('firezipcode', name);
  };
  const valueFireCity = (name: string | number): void => {
    setValueFireCity(name);
    validateField('firecity', name);
  };
  const valueFireMessage = (name: string | number): void => {
    setValueFireMessage(name);
    validateField('firemessage', name);
  };
  const valuePrivacyNotice = (name: boolean): void => {
    setValuePrivacyNotice(name);
    validateField('privatenotice', name);
  };
  const valueFireRegisterDeclaration = (name: boolean): void => {
    setValueFireRegisterDeclaration(name);
    validateField('registerdeclaration', name);
  };

  const SubmitForm = event => {
    event.preventDefault();
    setErrorText(null);
    setResponseText(null);
    const token = getCSRFToken();
    // console.log(token);
    const csrfToken = getCookie('XSRF-TOKEN');
    let headers = new Headers({
      'Content-Type': 'application/json',
    });
    if (csrfToken !== null) {
      headers = new Headers({
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      });
    }
    fetch('/api/submit/fireregister', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        surname: getValueSurname,
        firstname: getValueFirstname,
        street: getValueStreet,
        zipcode: getValueZipCode,
        city: getValueCity,
        phone: getValuePhone,
        mobilephone: getValueMobilePhone,
        email: getValueEmail,
        firedate: getValueFireDate,
        firetime: getValueFireTime,
        fireStreet: getValueFireStreet,
        firezipcode: getValueFireZipCode,
        firecity: getValueFireCity,
        firemessage: getValueFireMessage,
        fireregisterdeclaration: getValueFireRegisterDeclaration,
        privacynotice: getValuePrivacyNotice,
        'csrf-token': token,
        _token: token,
      }),
    })
      .then(response => response.json())
      .then(data => CheckResponse(data))
      .catch(err => setCatchError(err));
  };

  useEffect(() => {
    async function callZipCityStreet(zip: number, city: string) {
      const token = getCSRFToken();
      const csrfToken = getCookie('XSRF-TOKEN');
      let headers = new Headers({
        'Content-Type': 'application/json',
      });
      if (csrfToken !== null) {
        headers = new Headers({
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        });
      }
      try {
        let response = await fetch(`/api/checkadress`, {
          method: 'POST',
          headers,
          body: JSON.stringify({
            zipcode: zip,
            cityname: city,
            'csrf-token': token,
            _token: token,
          }),
        });
        response = await response.json();
        // setDefault(response);
        // setLoading(false);
      } catch (error) {
        console.error(error);
      }
    }

    let zip = 0;
    let city = '';
    if (getValueZipCode.length() === 5) {
      if (getValueZipCode.isNumber()) {
        zip = getValueZipCode as number;
      }
    }
    if (getValueCity.length() >= 3) {
      city = getValueCity;
    }
    if (zip !== 0) {
      callZipCityStreet(zip, city);
    }
  }, [getValueZipCode, getValueCity]);

  const hinweis = '/fileadmin/hinweise_gartenabfaelle_verbrennen.pdf';
  return (
    <ErrorBoundary>
      <ErrorBoundary>
        <SaveInfoError responseText={responseText} errorText={errorText} />
      </ErrorBoundary>
      <FireDepartmentFireRegister href={hinweis} />
      <Row>
        <Col xxl={6} xl={6} lg={6} md={6} sm={12} xs={12}>
          <RowHeadline label="Persönliche Angaben" headlineSize="h6" />
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                required
                label="Nachname"
                name="surname"
                value=""
                setParentValue={valueSurname}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                required
                label="Vorname"
                name="firstname"
                value=""
                setParentValue={valueFirstname}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                required
                label="Straße & Hausnr"
                name="street"
                value=""
                setParentValue={valueStreet}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                required
                label="PLZ"
                name="zipcode"
                value=""
                setParentValue={valueZipCode}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                required
                label="Wohnort"
                name="city"
                value=""
                setParentValue={valueCity}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput label="Telefon" name="phone" value="" setParentValue={valuePhone} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                required
                label="Mobiltelefon"
                name="mobilephone"
                value=""
                setParentValue={valueMobilePhone}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                required
                label="Emailadresse"
                name="email"
                value=""
                setParentValue={valueEmail}
              />
            </Col>
          </Row>
        </Col>
        <Col xxl={6} xl={6} lg={6} md={6} sm={12} xs={12}>
          <RowHeadline label="Angaben zum geplanten Feuer" headlineSize="h6" />
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInputDate
                required
                label="Datum"
                name="date"
                value=""
                setParentValue={valueFireDate}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInputTime
                required
                label="Uhrzeit"
                name="time"
                value=""
                setParentValue={valueFireTime}
              />
            </Col>
          </Row>
          <Spacer paragraph />
          <RowHeadline
            label="Bei Anweichender Adresse von der privaten Adresse"
            headlineSize="h6"
          />
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                label="Straße & Hausnr"
                name="fire_street"
                value=""
                setParentValue={valueFireStreet}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput
                label="PLZ"
                name="fire_zipcode"
                value=""
                setParentValue={valueFireZipCode}
              />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelInput label="Ort" name="fire_city" value="" setParentValue={valueFireCity} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <LabelTextarea
                label="Bemerkung"
                name="fire_message"
                value=""
                setParentValue={valueFireMessage}
              />
            </Col>
          </Row>
        </Col>
      </Row>
      <Spacer paragraph />
      <FireRegisterDeclarationOfConsent
        setParentValue={valueFireRegisterDeclaration}
        href={hinweis}
      />
      <Spacer paragraph />
      <PrivacyNotice setParentValue={valuePrivacyNotice} />
      <Spacer paragraph />
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <Button
            disabled={!getFormValid}
            onClick={SubmitForm}
            type="submit"
            label="absenden"
            className="btn btn-primary"
          />
        </Col>
      </Row>
      <ErrorBoundary>
        <SaveInfoError responseText={responseText} errorText={errorText} />
      </ErrorBoundary>
    </ErrorBoundary>
  );
};
export default ContentEmergencyFireRegister;

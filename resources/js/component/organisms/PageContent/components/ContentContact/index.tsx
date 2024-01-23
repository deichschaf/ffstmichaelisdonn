import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { InputLabel } from '@mui/material';
import { ContentContactProps } from '../../../../../props/props';
import Button from '../../../../atoms/Buttons/Button';
import LabelInput from '../../../../atoms/Form/LabelInput';
import LabelInputDate from '../../../../atoms/Form/LabelInputDate';
import LabelInputTime from '../../../../atoms/Form/LabelInputTime';
import LabelTextarea from '../../../../atoms/Form/LabelTextarea';
import ContactFormInfoLine from '../../../../molecules/ContactFormInfoLine';
import FireDepartmentFireRegister from '../../../../molecules/FireDepartmentFireRegister';
import ErrorBoundary from '../../../errorboundary';
import BuildEmergencyYear from '../ContentEmergency/modules/BuildEmergencyYear';
import YearSelector from '../ContentEmergency/modules/YearSelector';

const ContentContact: React.FC<React.PropsWithChildren<ContentContactProps>> = (
  props: ContentContactProps,
): JSX.Element => {
  const [getValueSurname, setValueSurname] = useState<any>('');
  const [getValueFirstname, setValueFirstname] = useState<any>('');
  const [getValueStreet, setValueStreet] = useState<any>('');
  const [getValueZipCode, setValueZipCode] = useState<any>('');
  const [getValueCity, setValueCity] = useState<any>('');
  const [getValuePhone, setValuePhone] = useState<any>('');
  const [getValueMobilePhone, setValueMobilePhone] = useState<any>('');
  const [getValueEmail, setValueEmail] = useState<any>('');
  const [getValueMessage, setValueMessage] = useState<any>('');

  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const valueSurname = (name: string | number): void => {
    setValueSurname(name);
  };
  const valueFirstname = (name: string | number): void => {
    setValueFirstname(name);
  };
  const valueStreet = (name: string | number): void => {
    setValueStreet(name);
  };
  const valueZipCode = (name: string | number): void => {
    setValueZipCode(name);
  };
  const valueCity = (name: string | number): void => {
    setValueCity(name);
  };
  const valuePhone = (name: string | number): void => {
    setValuePhone(name);
  };
  const valueMobilePhone = (name: string | number): void => {
    setValueMobilePhone(name);
  };
  const valueEmail = (name: string | number): void => {
    setValueEmail(name);
  };
  const valueMessage = (name: string | number): void => {
    setValueMessage(name);
  };

  return (
    <ErrorBoundary>
      <ContactFormInfoLine />
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
          <LabelInput label="Vorname" name="firstname" value="" setParentValue={valueFirstname} />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <LabelInput label="Straße & Hausnr" name="street" value="" setParentValue={valueStreet} />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <LabelInput label="PLZ" name="zipcode" value="" setParentValue={valueZipCode} />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <LabelInput label="Wohnort" name="city" value="" setParentValue={valueCity} />
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
            label="Mobiltelefon"
            name="mobilephone"
            value=""
            setParentValue={valueMobilePhone}
          />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <LabelInput label="Emailadresse" name="email" value="" setParentValue={valueEmail} />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <LabelTextarea
            required
            label="Bemerkung"
            name="message"
            value=""
            setParentValue={valueMessage}
          />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} />
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <Button type="submit" label="absenden" className="btn btn-primary" />
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ContentContact;

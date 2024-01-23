import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { FooterContactProps } from '../../../../props/props';
import FAR from '../../../atoms/Icon/FAR';
import FAS from '../../../atoms/Icon/FAS';
import Notruf from '../../../atoms/Notruf';
import PhoneNumber from '../../../atoms/PhoneNumber';
import ErrorBoundary from '../../errorboundary';

const FooterContact: React.FC<React.PropsWithChildren<FooterContactProps>> = (
  props: FooterContactProps,
): JSX.Element => {
  if (typeof props.footer === 'undefined') {
    return <></>;
  }
  if (typeof props.footer.contact === 'undefined') {
    return <></>;
  }
  let companyName = '';
  let companyStreet = '';
  let companyCity = '';
  let companyPhone = '';
  let companyEmail = '';
  if (props.footer.contact.contact_factory !== 'undefined') {
    companyName = props.footer.contact.contact_factory;
  }
  if (props.footer.contact.contact_street !== 'undefined') {
    companyStreet = props.footer.contact.contact_street;
  }
  if (
    props.footer.contact.contact_zipcode !== 'undefined' ||
    props.footer.contact.contact_city !== 'undefined'
  ) {
    if (props.footer.contact.contact_zipcode !== '') {
      companyCity = props.footer.contact.contact_zipcode;
    }
    if (props.footer.contact.contact_city !== '') {
      if (companyCity !== '') {
        companyCity += ' ';
      }
      companyCity += props.footer.contact.contact_city;
    }
  }
  if (props.footer.contact.contact_phone !== 'undefined') {
    companyPhone = props.footer.contact.contact_phone;
  }
  if (props.footer.contact.contact_email !== 'undefined') {
    companyEmail = props.footer.contact.contact_email;
  }
  return (
    <ErrorBoundary>
      <h4 className="headline">Kontakt</h4>
      <p className="text">
        {companyName !== '' ? (
          <>
            {companyName}
            <br />
          </>
        ) : (
          <></>
        )}
        {companyStreet !== '' ? (
          <>
            {companyStreet}
            <br />
          </>
        ) : (
          <></>
        )}
        {companyCity !== '' ? <>{companyCity}</> : <></>}
      </p>
      {companyPhone !== '' ? (
        <p className="text">
          Wehrführer:
          <PhoneNumber telephonenumber={companyPhone}>
            <FAS className="phone" /> {companyPhone}
          </PhoneNumber>
          <br />
        </p>
      ) : (
        <></>
      )}
      {companyEmail !== '' ? (
        <p className="text">
          <a href={`mailto:${companyEmail}`}>
            <FAR className="envelope" /> {companyEmail}
          </a>
          <br />
        </p>
      ) : (
        <></>
      )}
      <Notruf />
    </ErrorBoundary>
  );
};
export default FooterContact;

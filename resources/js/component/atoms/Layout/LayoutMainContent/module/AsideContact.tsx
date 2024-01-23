import React from 'react';
import { AsideContactProps } from '../../../../../props/props';
import ErrorBoundary from '../../../../organisms/errorboundary';
import FAR from '../../../Icon/FAR';
import FAS from '../../../Icon/FAS';
import PhoneNumber from '../../../PhoneNumber';

const AsideContact: React.FC<React.PropsWithChildren<AsideContactProps>> = (
  props: AsideContactProps,
): JSX.Element => {
  if (typeof props.pagedata === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.page === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.page.contact === 'undefined') {
    return <></>;
  }
  const { contact } = props.pagedata.page;
  let companyName = '';
  let companyStreet = '';
  const companyCity = '';
  const companyPhone = '';
  const companyEmail = '';
  if (contact.contact_factory !== 'undefined') {
    companyName = contact.contact_factory;
  }
  if (contact.contact_street !== 'undefined') {
    companyStreet = contact.contact_street;
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
    </ErrorBoundary>
  );
};
export default AsideContact;

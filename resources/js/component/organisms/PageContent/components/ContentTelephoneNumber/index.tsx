import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentTelephoneNumberProps } from '../../../../../props/props';
import Link from '../../../../atoms/Link';
import PhoneNumber from '../../../../atoms/PhoneNumber';
import GridSimple from '../../../../molecules/GridSimple';
import Spacer from '../../../../molecules/Spacer';
import ErrorBoundary from '../../../errorboundary';
import ContentSeperator from '../ContentSeperator';

const ContentTelephoneNumber: React.FC<React.PropsWithChildren<ContentTelephoneNumberProps>> = (
  props: ContentTelephoneNumberProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.telephonenumber === 'undefined') {
    return <></>;
  }

  function makeEntry(item, idx, length) {
    return (
      <ErrorBoundary key={idx}>
        <Row>
          <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
            {item.organisation}
            {item.organisation_description !== null ? (
              <>
                <br />
                {item.organisation_description}
              </>
            ) : (
              <></>
            )}
            {item.website !== null ? (
              <>
                <br />
                <Link target="_blank" href={item.website} title={item.website_title} />
                {item.website_description !== null ? (
                  <>
                    <br />
                    {item.website_description}
                  </>
                ) : (
                  <></>
                )}
              </>
            ) : (
              <></>
            )}
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
            <PhoneNumber telephonenumber={item.telephone_number}>
              {item.telephone_number}
            </PhoneNumber>
          </Col>
        </Row>
        {length > 1 && idx < length - 1 ? (
          <>
            <Spacer />
            <ContentSeperator />
            <Spacer />
          </>
        ) : (
          <></>
        )}
      </ErrorBoundary>
    );
  }
  function makeEntrys(item, idx, numbers, title) {
    const getTelephoneNumbers = numbers[item];
    const { length } = getTelephoneNumbers;
    return (
      <ErrorBoundary key={idx}>
        <GridSimple lable={title}>
          <Row>
            <Col xxl={8} xl={8} lg={8} md={8} sm={12} xs={12}>
              Organisation
            </Col>
            <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
              Rufnummer
            </Col>
          </Row>
          {getTelephoneNumbers.map((item2, idx2) => makeEntry(item2, idx2, length))}
        </GridSimple>
      </ErrorBoundary>
    );
  }

  const { telephonenumber } = props.data;
  return (
    <ErrorBoundary>
      {Object.keys(telephonenumber.types).map((item, idx) =>
        makeEntrys(item, idx, telephonenumber.telephonenumbers, telephonenumber.types[item]),
      )}
    </ErrorBoundary>
  );
};
export default ContentTelephoneNumber;

import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { BloodDonationTermineProps } from '../../../props/props';
import Spacer from '../../molecules/Spacer';
import ErrorBoundary from '../../organisms/errorboundary';
import ContentRow from '../../organisms/PageContent/components/ContentRow';
import ContentSeperator from '../../organisms/PageContent/components/ContentSeperator';
import Link from '../Link';
import LinkFA from '../LinkFA';
import SVGIcon from '../SVGIcon';

const BloodDonationTermine: React.FC<React.PropsWithChildren<BloodDonationTermineProps>> = (
  props: BloodDonationTermineProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }

  if (typeof props.data.blooddonation === 'undefined') {
    return <></>;
  }
  if (typeof props.data.blooddonation === 'undefined') {
    return <></>;
  }
  if (props.data.blooddonation.length === 0) {
    return <></>;
  }
  const { length } = props.data.blooddonation;
  return (
    <ErrorBoundary>
      {props.data.blooddonation.map((item, idx) => (
        <div key={idx} className="colorchanger">
          <ContentRow>
            <Row>
              <Col xxl={12} xl={12} lg={12} md={2} sm={12} xs={12}>
                {item.day}
              </Col>
              <Col xxl={12} xl={12} lg={12} md={2} sm={12} xs={12}>
                {item.time}
              </Col>
              {item.street_addition !== '' && item.street_addition !== null ? (
                <Col xxl={12} xl={12} lg={12} md={2} sm={12} xs={12}>
                  {item.street_addition}
                </Col>
              ) : (
                <></>
              )}
              <Col xxl={12} xl={12} lg={12} md={2} sm={12} xs={12}>
                {item.street}
              </Col>
              <Col xxl={12} xl={12} lg={12} md={2} sm={12} xs={12}>
                {item.zipcode} {item.city}
              </Col>
              <Col xxl={12} xl={12} lg={12} md={2} sm={12} xs={12}>
                <LinkFA target="_blank" href={item.link} title="zum Termin" />
              </Col>
            </Row>
          </ContentRow>
          {length > 1 && idx < length - 1 ? (
            <>
              <Spacer />
              <ContentSeperator />
              <Spacer />
            </>
          ) : (
            <></>
          )}
        </div>
      ))}
    </ErrorBoundary>
  );
};
export default BloodDonationTermine;

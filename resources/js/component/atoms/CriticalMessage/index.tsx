import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { CriticalMessageProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import SVGIcon from '../SVGIcon';

const CriticalMessage: React.FC<React.PropsWithChildren<CriticalMessageProps>> = (
  props: CriticalMessageProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.critical === 'undefined') {
    return <></>;
  }
  if (props.data.critical.length === 0) {
    return <></>;
  }
  return (
    <ErrorBoundary>
      {props.data.critical.map((item, idx) => (
        <div key={idx}>
          <Row>
            <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={2}>
              {item.msgType !== 'Cancel' ? (
                <SVGIcon svg="NationalWarnSign" alt="Bevölkerungswarnung" />
              ) : (
                <SVGIcon svg="NationalWarnSignCancel" alt="Bevölkerungswarnung" />
              )}
            </Col>
            <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={10}>
              {item.event}
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              {item.headline}
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <div dangerouslySetInnerHTML={{ __html: item.description }} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <div dangerouslySetInnerHTML={{ __html: item.sender }} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              {item.send}
            </Col>
          </Row>
        </div>
      ))}
    </ErrorBoundary>
  );
};
export default CriticalMessage;

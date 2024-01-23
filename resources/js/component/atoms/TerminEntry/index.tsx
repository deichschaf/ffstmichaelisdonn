import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { TermineEntryProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import PictureSourcSet from '../Picture/SourceSet';

const TermineEntry: React.FC<React.PropsWithChildren<TermineEntryProps>> = (
  props: TermineEntryProps,
): JSX.Element => {
  if (typeof props.sign === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={3}>
          {props.sign !== '' ? <PictureSourcSet img="/grfx/{props.sign}" title="" alt="" /> : ''}
        </Col>
        <Col xxl={9} xl={9} lg={9} md={9} sm={9} xs={9}>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              {props.date} -{props.time}
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              {props.termin}
            </Col>
          </Row>
          {props.place !== '' ? (
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                {props.place}
              </Col>
            </Row>
          ) : (
            ''
          )}
          {props.description !== '' ? (
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                {props.description}
              </Col>
            </Row>
          ) : (
            ''
          )}
          {props.clothes !== '' ? (
            <Row>
              <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
                {props.clothes}
              </Col>
            </Row>
          ) : (
            ''
          )}
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default TermineEntry;

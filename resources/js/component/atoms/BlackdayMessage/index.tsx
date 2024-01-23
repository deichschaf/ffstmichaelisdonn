import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { BlackdayMessageProps } from '../../../props/props';
import GridBox from '../../molecules/GridBox';
import ErrorBoundary from '../../organisms/errorboundary';
import PictureSourcSet from '../Picture/SourceSet';
import SVGIcon from '../SVGIcon';
import H6 from '../Typography/H6';

const BlackdayMessage: React.FC<React.PropsWithChildren<BlackdayMessageProps>> = (
  props: BlackdayMessageProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <GridBox lable={props.data.title}>
        <Row>
          <Col xxl={2} xl={2} lg={2} md={4} sm={2} xs={2}>
            <SVGIcon svg="Ribbon" />
          </Col>
          <Col xxl={10} xl={10} lg={10} md={8} sm={10} xs={10}>
            <H6>{props.data.title}</H6>
            {props.data.text}
            <br />
            {props.data.homepage_owner}
          </Col>
        </Row>
      </GridBox>
    </ErrorBoundary>
  );
};
export default BlackdayMessage;

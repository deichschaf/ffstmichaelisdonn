import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { HappyHolidayProps } from '../../../props/props';
import GridBox from '../../molecules/GridBox';
import ErrorBoundary from '../../organisms/errorboundary';
import PictureSourcSet from '../Picture/SourceSet';
import H2 from '../Typography/H2';

const HappyHoliday: React.FC<React.PropsWithChildren<HappyHolidayProps>> = (
  props: HappyHolidayProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.happyholiday === 'undefined') {
    return <></>;
  }
  if (typeof props.data.happyholiday.content === 'undefined') {
    return <></>;
  }
  const holiday = props.data.happyholiday;
  return (
    <ErrorBoundary>
      <GridBox lable={holiday.text}>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={6} sm={6} xs={12}>
            <PictureSourcSet
              img={holiday.picture}
              path="/fileadmin/holidays/"
              className="picture"
            />
          </Col>
          <Col xxl={8} xl={8} lg={8} md={6} sm={6} xs={12}>
            <H2 className="no-border" label={holiday.content} />
          </Col>
        </Row>
      </GridBox>
    </ErrorBoundary>
  );
};
export default HappyHoliday;

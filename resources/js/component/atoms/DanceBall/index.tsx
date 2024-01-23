import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { DanceBallProps } from '../../../props/props';
import Countdown from '../../molecules/Countdown';
import GridBox from '../../molecules/GridBox';
import ErrorBoundary from '../../organisms/errorboundary';
import DownloadLink from '../Download/Link';
import PictureSourcSet from '../Picture/SourceSet';
import P from '../Typography/P';

const DanceBall: React.FC<React.PropsWithChildren<DanceBallProps>> = (
  props: DanceBallProps
): JSX.Element => {
  const [currentTime, setCurrentTime] = useState(Date.now());

  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.danceball === 'undefined') {
    return <></>;
  }
  const { danceball } = props.data;
  if (typeof danceball.showuntil !== 'string') {
    return <></>;
  }
  const targetTime = Date.parse(danceball.showuntil);
  const timeBetween = targetTime - currentTime;
  if (timeBetween <= 0) {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <GridBox lable={danceball.text}>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={6} sm={6} xs={12}>
            <PictureSourcSet
              img={danceball.picture}
              images={danceball.images}
              path="/fileadmin/danceball/"
              className="picture"
            />
          </Col>
          <Col xxl={8} xl={8} lg={8} md={6} sm={6} xs={12}>
            <P label={danceball.content} />
            <DownloadLink
              href={danceball.href}
              linkText={danceball.linktext}
              target={danceball.target}
              icon={danceball.icon}
              size={danceball.size}
            />
            <Countdown datetime={danceball.datetime} />
          </Col>
        </Row>
      </GridBox>
    </ErrorBoundary>
  );
};
export default DanceBall;

import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { AnnualGeneralMeetingProps } from '../../../props/props';
import Countdown from '../../molecules/Countdown';
import GridBox from '../../molecules/GridBox';
import ErrorBoundary from '../../organisms/errorboundary';
import DownloadLink from '../Download/Link';
import PictureSourcSet from '../Picture/SourceSet';
import P from '../Typography/P';

const AnnualGeneralMeeting: React.FC<React.PropsWithChildren<AnnualGeneralMeetingProps>> = (
  props: AnnualGeneralMeetingProps
): JSX.Element => {
  const [currentTime, setCurrentTime] = useState(Date.now());

  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.annualgeneralmeeting === 'undefined') {
    return <></>;
  }
  const { annualgeneralmeeting } = props.data;
  if (typeof annualgeneralmeeting.showuntil !== 'string') {
    return <></>;
  }
  const targetTime = Date.parse(annualgeneralmeeting.showuntil);
  const timeBetween = targetTime - currentTime;
  if (timeBetween <= 0) {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <GridBox lable={annualgeneralmeeting.text}>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={6} sm={6} xs={12}>
            <PictureSourcSet
              img={annualgeneralmeeting.picture}
              images={annualgeneralmeeting.images}
              path="/fileadmin/generalmeeting/"
              className="picture"
            />
          </Col>
          <Col xxl={8} xl={8} lg={8} md={6} sm={6} xs={12}>
            <P label={annualgeneralmeeting.content} />
            <DownloadLink
              href={annualgeneralmeeting.href}
              linkText={annualgeneralmeeting.linktext}
              target={annualgeneralmeeting.target}
              icon={annualgeneralmeeting.icon}
              size={annualgeneralmeeting.size}
            />
            <Countdown datetime={annualgeneralmeeting.datetime} />
          </Col>
        </Row>
      </GridBox>
    </ErrorBoundary>
  );
};
export default AnnualGeneralMeeting;

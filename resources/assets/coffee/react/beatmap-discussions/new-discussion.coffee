###
#    Copyright 2015-2017 ppy Pty. Ltd.
#
#    This file is part of osu!web. osu!web is distributed with the hope of
#    attracting more community contributions to the core ecosystem of osu!.
#
#    osu!web is free software: you can redistribute it and/or modify
#    it under the terms of the Affero GNU General Public License version 3
#    as published by the Free Software Foundation.
#
#    osu!web is distributed WITHOUT ANY WARRANTY; without even the implied
#    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
#    See the GNU Affero General Public License for more details.
#
#    You should have received a copy of the GNU Affero General Public License
#    along with osu!web.  If not, see <http://www.gnu.org/licenses/>.
###

{button, div, input, p, span, textarea} = React.DOM
el = React.createElement

bn = 'beatmap-discussion-new'

BeatmapDiscussions.NewDiscussion = React.createClass
  mixins: [React.addons.PureRenderMixin]


  getInitialState: ->
    message: ''
    timestamp: null


  componentDidMount: ->
    @throttledPost = _.throttle @post, 1000


  componentWillUnmount: ->
    @postXhr?.abort()
    @throttledPost.cancel()


  render: ->
    div
      className: 'osu-page osu-page--small'
      div
        className: bn
        div className: "page-title",
          osu.trans('beatmaps.discussions.new.title')

        div className: "#{bn}__content",
          div
            className: "#{bn}__avatar"
            el UserAvatar, user: @props.currentUser, modifiers: ['full-rounded']

          div className: "#{bn}__message",
            if @props.currentUser.id?
              textarea
                className: "#{bn}__message-area"
                value: @state.message
                onChange: @setMessage
                placeholder: osu.trans 'beatmaps.discussions.message_placeholder'
            else
              osu.trans('beatmaps.discussions.require-login')

        div className: "#{bn}__footer",
          div
            className: "#{bn}__footer-content"
            'data-visibility': if @props.mode != 'timeline' then 'hidden'
            div
              key: 'label'
              className: "#{bn}__timestamp-col #{bn}__timestamp-col--label"
              osu.trans('beatmaps.discussions.new.timestamp')
            div
              key: 'timestamp'
              className: "#{bn}__timestamp-col"
              if @state.timestamp?
                BeatmapDiscussionHelper.formatTimestamp @state.timestamp
              else
                osu.trans('beatmaps.discussions.new.timestamp_missing')

          div
            className: "#{bn}__footer-content #{bn}__footer-content--right"
            if @props.mode == 'timeline'
              ['praise', 'suggestion', 'problem'].map @submitButton
            else
              el BigButton,
                modifiers: ['beatmap-discussion']
                text: osu.trans('common.buttons.post')
                props:
                  disabled: !@validPost()
                  onClick: @post


  setTimestamp: (e) ->
    @setState timestamp: e.currentTarget.value


  setMessage: (e) ->
    if @props.mode == 'timeline'
      callback = @parseTimestamp

    @setState message: e.currentTarget.value, callback


  post: (e) ->
    return unless @validPost()

    @postXhr?.abort()
    LoadingOverlay.show()

    data =
        beatmapset_id: @props.currentBeatmap.beatmapset_id
        beatmap_discussion_post:
          message: @state.message

    switch @props.mode
      when 'general'
        data.beatmap_discussion =
          beatmap_id: @props.currentBeatmap.id
      when 'timeline'
        data.beatmap_discussion =
          message_type: e.currentTarget.dataset.type
          timestamp: @state.timestamp
          beatmap_id: @props.currentBeatmap.id

    @postXhr = $.ajax laroute.route('beatmap-discussion-posts.store'),
      method: 'POST'
      data: data

    .done (data) =>
      @setState
        message: ''
        timestamp: null

      $.publish 'beatmapDiscussionPost:markRead', id: data.beatmap_discussion_post_id
      $.publish 'beatmapsetDiscussion:update',
        beatmapsetDiscussion: data.beatmapset_discussion,
        callback: =>
          $.publish 'beatmapDiscussion:jump', id: data.beatmap_discussion_id

    .fail osu.ajaxError

    .always LoadingOverlay.hide


  submitButton: (type) ->
    el BigButton,
      key: type
      modifiers: ['beatmap-discussion']
      icon: BeatmapDiscussionHelper.messageType.icon[type]
      text: osu.trans("beatmaps.discussions.message_type.#{type}")
      props:
        disabled: !@validPost()
        'data-type': type
        onClick: @post


  validPost: ->
    return false if @state.message.length == 0

    if @props.mode == 'timeline'
      @state.timestamp?
    else
      true


  parseTimestamp: ->
    timestampRe = @state.message.match /\b(\d{2,}):(\d{2})[:.](\d{3})\b/

    @setState timestamp:
      if timestampRe?
        timestamp = timestampRe.slice(1).map (x) => parseInt x, 10

        # this isn't all that smart
        (timestamp[0] * 60 + timestamp[1]) * 1000 + timestamp[2]
      else
        null
